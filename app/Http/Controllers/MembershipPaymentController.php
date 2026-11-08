<?php

namespace App\Http\Controllers;

use App\Mail\MemberWelcomeMail;
use App\Models\Member;
use App\Models\MemberPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MembershipPaymentController extends Controller
{
    /**
     * Display the Membership Dues Checkout page.
     */
    public function showPaymentPage(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        // Administrators do not pay membership dues
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        /** @var Member|null $member */
        $member = $user->member;

        if (! $member) {
            $nameParts = explode(' ', $user->name, 2);
            $member = Member::create([
                'user_id' => $user->id,
                'member_number' => 'BANF-MBR-'.date('Y').'-'.strtoupper(Str::random(5)),
                'first_name' => $nameParts[0] ?? 'Member',
                'last_name' => $nameParts[1] ?? 'User',
                'email' => $user->email,
                'phone' => '+234 800 000 0000',
                'category' => 'professional',
                'state' => 'Kaduna',
                'country' => 'Nigeria',
                'status' => 'active',
                'payment_status' => 'pending',
                'qr_code_token' => (string) Str::uuid(),
                'joined_at' => now()->toDateString(),
            ]);
        }

        // If member has already paid dues, grant direct access to dashboard
        if ($member->isPaid()) {
            return redirect()->route('member.dashboard')->with('info', 'Your annual membership dues are fully paid and active.');
        }

        $category = $member->category ?? 'professional';
        $feeConfig = config("membership.fees.{$category}", [
            'amount' => 25000,
            'label' => 'Professional Member',
            'badge' => 'Practicing Professional',
            'description' => 'Annual dues for practicing visual designers, brand architects, and marketing practitioners.',
        ]);

        $bankDetails = config('membership.bank_details');
        $paystackPublicKey = config('membership.paystack.public_key');

        // Retrieve existing pending/under-review payment or create a pending record
        $pendingPayment = MemberPayment::where('member_id', $member->id)
            ->whereIn('status', ['pending', 'under_review'])
            ->latest()
            ->first();

        if (! $pendingPayment) {
            $pendingPayment = MemberPayment::create([
                'member_id' => $member->id,
                'user_id' => $user->id,
                'category' => $category,
                'amount' => $feeConfig['amount'],
                'currency' => 'NGN',
                'payment_gateway' => 'paystack',
                'status' => 'pending',
            ]);
        }

        return view('membership.payment', compact(
            'member',
            'user',
            'feeConfig',
            'bankDetails',
            'paystackPublicKey',
            'pendingPayment'
        ));
    }

    /**
     * Initialize Paystack Online Checkout.
     */
    public function initializePaystack(Request $request): RedirectResponse
    {
        $user = $request->user();
        /** @var Member|null $member */
        $member = $user->member;

        if (! $member) {
            $nameParts = explode(' ', $user->name, 2);
            $member = Member::create([
                'user_id' => $user->id,
                'member_number' => 'BANF-MBR-'.date('Y').'-'.strtoupper(Str::random(5)),
                'first_name' => $nameParts[0] ?? 'Member',
                'last_name' => $nameParts[1] ?? 'User',
                'email' => $user->email,
                'phone' => '+234 800 000 0000',
                'category' => 'professional',
                'state' => 'Kaduna',
                'country' => 'Nigeria',
                'status' => 'active',
                'payment_status' => 'pending',
                'qr_code_token' => (string) Str::uuid(),
                'joined_at' => now()->toDateString(),
            ]);
        }

        if ($member->isPaid()) {
            return redirect()->route('member.dashboard');
        }

        $amount = $member->getFeeAmount();
        $secretKey = config('membership.paystack.secret_key');

        // Check or generate pending payment record
        $payment = MemberPayment::where('member_id', $member->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (! $payment) {
            $payment = MemberPayment::create([
                'member_id' => $member->id,
                'user_id' => $user->id,
                'category' => $member->category,
                'amount' => $amount,
                'currency' => 'NGN',
                'payment_gateway' => 'paystack',
                'status' => 'pending',
            ]);
        }

        // If Paystack secret key is not set, provide helpful guidance
        if (empty($secretKey)) {
            // In local/testing development mode, allow instant simulated activation
            if (app()->environment('local', 'testing')) {
                $payment->update([
                    'status' => 'successful',
                    'gateway_reference' => 'SIMULATED-PAYSTACK-'.strtoupper(Str::random(10)),
                    'paid_at' => now(),
                ]);

                $member->markAsPaid('paystack', $amount, $payment->reference);

                try {
                    Mail::to($user->email)->send(new MemberWelcomeMail($user));
                } catch (\Throwable $e) {
                    Log::warning('Welcome email delivery error: '.$e->getMessage());
                }

                return redirect()->route('member.dashboard')->with(
                    'success',
                    "Membership Activated (Sandbox Mode)! Your {$member->category_label} annual dues of ₦".number_format($amount).' have been confirmed.'
                );
            }

            return back()->with('error', 'Paystack live payments are currently being configured by the Foundation. Please use the Direct Bank Transfer option below to complete your payment.');
        }

        try {
            $response = Http::withToken($secretKey)
                ->timeout(15)
                ->post(rtrim(config('membership.paystack.payment_url', 'https://api.paystack.co'), '/').'/transaction/initialize', [
                    'email' => $user->email,
                    'amount' => (int) ($amount * 100), // Paystack requires amount in Kobo
                    'reference' => $payment->reference,
                    'callback_url' => route('membership.payment.callback'),
                    'metadata' => [
                        'member_id' => $member->id,
                        'user_id' => $user->id,
                        'member_number' => $member->member_number,
                        'category' => $member->category,
                    ],
                ]);

            if ($response->successful() && $response->json('status')) {
                $authorizationUrl = $response->json('data.authorization_url');

                return redirect()->away($authorizationUrl);
            }

            Log::error('Paystack initialization failed', ['response' => $response->body()]);

            return back()->with('error', 'Could not initialize online checkout: '.($response->json('message') ?? 'Please try again or use Bank Transfer.'));
        } catch (\Throwable $e) {
            Log::error('Paystack connection exception: '.$e->getMessage());

            return back()->with('error', 'Unable to connect to Paystack payment gateway. Please try direct bank transfer or contact support.');
        }
    }

    /**
     * Handle Paystack Callback after card/bank payment.
     */
    public function handlePaystackCallback(Request $request): RedirectResponse
    {
        $reference = $request->query('reference') ?? $request->query('trxref');

        if (! $reference) {
            return redirect()->route('membership.payment')->with('error', 'No transaction reference found in callback.');
        }

        $payment = MemberPayment::where('reference', $reference)->first();

        if (! $payment) {
            return redirect()->route('membership.payment')->with('error', 'Invalid payment reference: '.$reference);
        }

        $member = $payment->member;
        $user = $payment->user;
        $secretKey = config('membership.paystack.secret_key');

        // Check if sandbox test mode without secret key
        if (empty($secretKey) && app()->environment('local', 'testing')) {
            $payment->update([
                'status' => 'successful',
                'gateway_reference' => 'TEST-CALLBACK-'.strtoupper(Str::random(10)),
                'paid_at' => now(),
            ]);

            $member->markAsPaid('paystack', $payment->amount, $reference);

            return redirect()->route('member.dashboard')->with('success', 'Annual membership dues confirmed! Welcome to Brands Academy Nigeria Foundation.');
        }

        try {
            $response = Http::withToken($secretKey)
                ->timeout(15)
                ->get(rtrim(config('membership.paystack.payment_url', 'https://api.paystack.co'), '/')."/transaction/verify/{$reference}");

            if ($response->successful() && $response->json('status') && $response->json('data.status') === 'success') {
                $paidAmountKobo = $response->json('data.amount');
                $paidAmountNaira = $paidAmountKobo / 100;

                $payment->update([
                    'status' => 'successful',
                    'gateway_reference' => (string) $response->json('data.id'),
                    'paid_at' => now(),
                ]);

                $member->markAsPaid('paystack', $paidAmountNaira, $reference);

                try {
                    Mail::to($user->email)->send(new MemberWelcomeMail($user));
                } catch (\Throwable $e) {
                    Log::warning('Welcome email delivery error: '.$e->getMessage());
                }

                return redirect()->route('member.dashboard')->with(
                    'success',
                    'Payment Successful! Your annual membership dues of ₦'.number_format($paidAmountNaira).' have been confirmed. Full member portal access is now unlocked.'
                );
            }

            $payment->update(['status' => 'failed']);

            return redirect()->route('membership.payment')->with(
                'error',
                'Payment verification failed: '.($response->json('data.gateway_response') ?? 'Transaction was not successful.')
            );
        } catch (\Throwable $e) {
            Log::error('Paystack verification error: '.$e->getMessage());

            return redirect()->route('membership.payment')->with('error', 'Error verifying payment. If you were debited, our Secretariat will confirm and activate your profile.');
        }
    }

    /**
     * Submit Direct Foundation Bank Transfer Receipt.
     */
    public function submitBankTransfer(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:5120'], // Max 5MB
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_bank' => ['required', 'string', 'max:255'],
            'transfer_reference' => ['nullable', 'string', 'max:255'],
            'transfer_date' => ['nullable', 'date'],
        ]);

        $user = $request->user();
        /** @var Member $member */
        $member = $user->member;

        if (! $member) {
            return redirect()->route('membership.register');
        }

        // Store proof of payment file
        $file = $request->file('payment_proof');
        $fileName = 'proof_'.$member->member_number.'_'.time().'.'.$file->getClientOriginalExtension();
        $storedPath = $file->storeAs('payment_proofs', $fileName, 'public');

        $notes = sprintf(
            'Bank: %s | Account/Depositor Name: %s | Date: %s | Session/Ref: %s',
            $request->input('sender_bank'),
            $request->input('sender_name'),
            $request->input('transfer_date', now()->toDateString()),
            $request->input('transfer_reference', 'N/A')
        );

        $amount = $member->getFeeAmount();

        // Update or create payment record
        $payment = MemberPayment::updateOrCreate(
            [
                'member_id' => $member->id,
                'status' => 'pending',
            ],
            [
                'user_id' => $user->id,
                'category' => $member->category,
                'amount' => $amount,
                'currency' => 'NGN',
                'payment_gateway' => 'bank_transfer',
                'status' => 'under_review',
                'receipt_path' => $storedPath,
                'notes' => $notes,
            ]
        );

        // Update member record
        $member->update([
            'payment_status' => 'under_review',
            'payment_method' => 'bank_transfer',
            'payment_reference' => $payment->reference,
            'payment_proof' => $storedPath,
        ]);

        return redirect()->route('membership.payment')->with(
            'success',
            'Bank transfer proof uploaded successfully! Our Secretariat will verify the transaction within 24 business hours to activate your portal.'
        );
    }

    /**
     * Webhook listener for Paystack server-to-server notifications.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $secretKey = config('membership.paystack.secret_key');
        $signature = $request->header('x-paystack-signature');

        if (! $secretKey || ! $signature) {
            return response()->json(['status' => 'ignored'], 400);
        }

        $input = $request->getContent();
        if ($signature !== hash_hmac('sha512', $input, $secretKey)) {
            Log::warning('Paystack webhook invalid signature detected');

            return response()->json(['status' => 'invalid signature'], 401);
        }

        $event = $request->json('event');
        $data = $request->json('data');

        if ($event === 'charge.success') {
            $reference = $data['reference'] ?? null;
            $payment = MemberPayment::where('reference', $reference)->first();

            if ($payment && ! $payment->isSuccessful()) {
                $amountPaid = ($data['amount'] ?? 0) / 100;
                $payment->update([
                    'status' => 'successful',
                    'gateway_reference' => (string) ($data['id'] ?? ''),
                    'paid_at' => now(),
                ]);

                $member = $payment->member;
                if ($member && ! $member->isPaid()) {
                    $member->markAsPaid('paystack', $amountPaid, $reference);

                    try {
                        Mail::to($payment->user->email)->send(new MemberWelcomeMail($payment->user));
                    } catch (\Throwable $e) {
                        Log::warning('Webhook welcome email error: '.$e->getMessage());
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
