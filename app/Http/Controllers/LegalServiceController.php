<?php

namespace App\Http\Controllers;

use App\Models\FilingDocument;
use App\Models\ServiceFiling;
use App\Services\LegalDeskService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LegalServiceController extends Controller
{
    public function __construct(
        protected LegalDeskService $legalDeskService
    ) {}

    /**
     * Public Legal Services Showcase.
     */
    public function index(Request $request): View
    {
        $allPricing = ServiceFiling::allPricing();
        $selectedType = $request->query('type', ServiceFiling::TYPE_CAC_BUSINESS_NAME);
        $user = $request->user();

        $pricingDetails = [];
        foreach ($allPricing as $key => $plan) {
            $pricingDetails[$key] = $this->legalDeskService->calculatePricing($key, $user);
        }

        return view('services.index', [
            'allPricing' => $allPricing,
            'pricingDetails' => $pricingDetails,
            'selectedType' => $selectedType,
        ]);
    }

    /**
     * Multi-step Filing Intake Wizard.
     */
    public function wizard(Request $request): View
    {
        $type = $request->query('type', ServiceFiling::TYPE_CAC_BUSINESS_NAME);
        $pricing = $this->legalDeskService->calculatePricing($type, $request->user());
        $allPricing = ServiceFiling::allPricing();

        return view('services.file_wizard', [
            'selectedType' => $type,
            'pricing' => $pricing,
            'allPricing' => $allPricing,
            'user' => $request->user(),
        ]);
    }

    /**
     * Process wizard submission, upload initial documents, and route to payment.
     */
    public function storeWizard(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'filing_type' => ['required', 'string', 'in:cac_business_name,cac_company_ltd,trademark,patent,copyright'],
            'proposed_name_1' => ['required', 'string', 'max:255'],
            'proposed_name_2' => ['nullable', 'string', 'max:255'],
            'proposed_name_3' => ['nullable', 'string', 'max:255'],
            'business_nature' => ['required', 'string', 'max:2000'],
            'industry_category' => ['nullable', 'string', 'max:255'],
            'business_address' => ['required', 'string', 'max:500'],
            'headquarters_state' => ['required', 'string', 'max:100'],
            'client_first_name' => ['required', 'string', 'max:100'],
            'client_last_name' => ['required', 'string', 'max:100'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_phone' => ['required', 'string', 'max:30'],
            'client_nin' => ['nullable', 'string', 'max:20'],
            'nin_slip' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'passport_photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'signature_specimen' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'trademark_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
            'additional_file' => ['nullable', 'file', 'mimes:pdf,zip,doc,docx,jpg,jpeg,png', 'max:20480'],
            'trademark_class' => ['nullable', 'string', 'max:100'],
            'directors_count' => ['nullable', 'integer', 'min:1', 'max:20'],
            'share_capital' => ['nullable', 'string', 'max:50'],
        ]);

        $filingData = [];
        if (! empty($validated['trademark_class'])) {
            $filingData['trademark_class'] = $validated['trademark_class'];
        }
        if (! empty($validated['directors_count'])) {
            $filingData['directors_count'] = $validated['directors_count'];
        }
        if (! empty($validated['share_capital'])) {
            $filingData['share_capital'] = $validated['share_capital'];
        }

        $validated['filing_data'] = $filingData;

        $filing = $this->legalDeskService->createFiling($validated, $request->user());

        // Process file attachments
        if ($request->hasFile('nin_slip')) {
            $this->legalDeskService->attachDocument($filing, $request->file('nin_slip'), FilingDocument::TYPE_NIN_SLIP);
        }
        if ($request->hasFile('passport_photo')) {
            $this->legalDeskService->attachDocument($filing, $request->file('passport_photo'), FilingDocument::TYPE_PASSPORT_PHOTO);
        }
        if ($request->hasFile('signature_specimen')) {
            $this->legalDeskService->attachDocument($filing, $request->file('signature_specimen'), FilingDocument::TYPE_SIGNATURE_SPECIMEN);
        }
        if ($request->hasFile('trademark_logo')) {
            $this->legalDeskService->attachDocument($filing, $request->file('trademark_logo'), FilingDocument::TYPE_TRADEMARK_LOGO);
        }
        if ($request->hasFile('additional_file')) {
            $this->legalDeskService->attachDocument($filing, $request->file('additional_file'), FilingDocument::TYPE_OTHER);
        }

        return redirect()->route('services.payment', $filing->tracking_code)
            ->with('success', 'Filing initiated! Please review summary and finalize statutory fee payment.');
    }

    /**
     * Filing Payment Summary & Checkout Screen.
     */
    public function paymentSummary(string $trackingCode): View
    {
        $filing = ServiceFiling::where('tracking_code', $trackingCode)
            ->with(['documents', 'statusLogs'])
            ->firstOrFail();

        return view('services.payment', [
            'filing' => $filing,
        ]);
    }

    /**
     * Initiate Online Payment for Filing.
     */
    public function pay(Request $request, string $trackingCode): RedirectResponse
    {
        $filing = ServiceFiling::where('tracking_code', $trackingCode)->firstOrFail();

        if ($filing->status !== ServiceFiling::STATUS_PAYMENT_PENDING) {
            return redirect()->route('services.track', ['code' => $filing->tracking_code])
                ->with('info', 'This filing has already been submitted and paid.');
        }

        $secretKey = config('membership.paystack.secret_key');
        $reference = 'LEGAL-'.strtoupper(Str::random(12));

        if (empty($secretKey)) {
            // Local fallback / sandbox payment simulation
            $this->legalDeskService->markAsPaid(
                $filing,
                gateway: 'paystack_simulated',
                reference: $reference
            );

            return redirect()->route('services.track', ['code' => $filing->tracking_code])
                ->with('success', 'Payment verified! Your filing has been officially lodged with the Legal Operations Desk.');
        }

        try {
            $callbackUrl = route('services.callback', $filing->tracking_code);

            $response = Http::withToken($secretKey)
                ->timeout(15)
                ->post('https://api.paystack.co/transaction/initialize', [
                    'email' => $filing->client_email,
                    'amount' => (int) round($filing->total_fee * 100),
                    'reference' => $reference,
                    'callback_url' => $callbackUrl,
                    'metadata' => [
                        'filing_id' => $filing->id,
                        'tracking_code' => $filing->tracking_code,
                        'filing_type' => $filing->filing_type,
                        'client_name' => "{$filing->client_first_name} {$filing->client_last_name}",
                    ],
                ]);

            if ($response->successful() && $response->json('status')) {
                $authUrl = $response->json('data.authorization_url');

                return redirect()->away($authUrl);
            }

            Log::error('Paystack Legal Desk Init Failed', ['response' => $response->json()]);

            return back()->with('error', 'Could not initialize payment gateway. Please try again.');
        } catch (\Throwable $e) {
            Log::error('Paystack Legal Desk Exception', ['error' => $e->getMessage()]);

            return back()->with('error', 'Gateway connection error: '.$e->getMessage());
        }
    }

    /**
     * Payment Gateway Callback.
     */
    public function callback(Request $request, string $trackingCode): RedirectResponse
    {
        $reference = $request->query('reference');
        $filing = ServiceFiling::where('tracking_code', $trackingCode)->firstOrFail();

        if (! $reference) {
            return redirect()->route('services.payment', $filing->tracking_code)
                ->with('error', 'Invalid payment reference provided.');
        }

        $secretKey = config('membership.paystack.secret_key');

        if (empty($secretKey)) {
            $this->legalDeskService->markAsPaid($filing, 'paystack_simulated', $reference);

            return redirect()->route('services.track', ['code' => $filing->tracking_code])
                ->with('success', 'Payment verified! Your filing is now under review.');
        }

        try {
            $response = Http::withToken($secretKey)
                ->timeout(15)
                ->get("https://api.paystack.co/transaction/verify/{$reference}");

            if ($response->successful() && $response->json('data.status') === 'success') {
                $this->legalDeskService->markAsPaid($filing, 'paystack', $reference);

                return redirect()->route('services.track', ['code' => $filing->tracking_code])
                    ->with('success', 'Payment verified! Your filing has been submitted to the Legal Desk.');
            }

            return redirect()->route('services.payment', $filing->tracking_code)
                ->with('error', 'Payment verification failed: '.($response->json('data.gateway_response') ?? 'Transaction not completed.'));
        } catch (\Throwable $e) {
            Log::error('Paystack Legal Verify Error', ['error' => $e->getMessage()]);

            return redirect()->route('services.payment', $filing->tracking_code)
                ->with('error', 'Payment verification exception: '.$e->getMessage());
        }
    }

    /**
     * Public Verification & Filing Tracker.
     */
    public function track(Request $request, ?string $trackingCode = null): View
    {
        $code = $trackingCode ?: $request->query('code');
        $filing = null;
        $searched = false;

        if (! empty($code)) {
            $searched = true;
            $filing = ServiceFiling::where('tracking_code', trim($code))
                ->with(['documents', 'statusLogs.changedByUser'])
                ->first();
        }

        return view('services.track', [
            'code' => $code,
            'filing' => $filing,
            'searched' => $searched,
        ]);
    }

    /**
     * Preliminary Name Availability Pre-Check API.
     */
    public function precheck(Request $request): JsonResponse
    {
        $name = trim((string) $request->query('name', ''));

        if (empty($name)) {
            return response()->json([
                'available' => false,
                'matches_count' => 0,
                'similar' => [],
                'message' => 'Please provide a proposed brand or business name to search.',
            ], 422);
        }

        $matches = ServiceFiling::query()
            ->where(function ($query) use ($name) {
                $query->where('proposed_name_1', 'like', "%{$name}%")
                    ->orWhere('proposed_name_2', 'like', "%{$name}%")
                    ->orWhere('proposed_name_3', 'like', "%{$name}%");
            })
            ->limit(5)
            ->get(['id', 'filing_type', 'proposed_name_1', 'status']);

        $count = $matches->count();
        $isAvailable = ($count === 0);

        return response()->json([
            'name' => $name,
            'available' => $isAvailable,
            'matches_count' => $count,
            'similar' => $matches->pluck('proposed_name_1')->unique()->values(),
            'message' => $isAvailable
                ? "Excellent! \"{$name}\" shows clear preliminary availability in our registry database. Proceed to file your CAC or Trademark application."
                : "Notice: Found {$count} existing or pending filing(s) with similar names. Our accredited legal agents will conduct official registry searches to ensure seamless approval.",
        ]);
    }

    /**
     * Interactive Statutory Fee Calculator & Trademark Nice Class Explorer.
     */
    public function calculator(Request $request): View
    {
        $allPricing = ServiceFiling::allPricing();
        $user = $request->user();

        // Prominent commercial Nice Classification classes in Nigerian market
        $niceClasses = [
            1 => ['title' => 'Chemicals & Industrial Substances', 'desc' => 'Chemicals for use in industry, science, agriculture, and forestry.'],
            2 => ['title' => 'Paints, Coatings & Colorants', 'desc' => 'Paints, varnishes, lacquers, rust preservatives, printing inks.'],
            3 => ['title' => 'Cosmetics, Skincare & Cleaning', 'desc' => 'Soaps, perfumery, essential oils, cosmetics, hair lotions, beauty formulations.'],
            4 => ['title' => 'Lubricants, Oils & Fuels', 'desc' => 'Industrial lubricants, petroleum oils, greases, illuminating fuels.'],
            5 => ['title' => 'Pharmaceuticals & Supplements', 'desc' => 'Medicinal preparations, nutraceuticals, dietary supplements, baby food.'],
            9 => ['title' => 'Software, Mobile Apps & Hardware', 'desc' => 'Mobile applications, computer software, digital devices, fintech tokens, electronics.'],
            14 => ['title' => 'Jewelry, Timepieces & Precious Metals', 'desc' => 'Precious metals, diamonds, watches, luxury chronographs.'],
            16 => ['title' => 'Print, Packaging & Stationery', 'desc' => 'Printed publications, corporate stationery, paper cartons, packaging materials.'],
            18 => ['title' => 'Leather Goods, Luggage & Bags', 'desc' => 'Leather goods, travel bags, wallets, backpacks, equestrian gear.'],
            25 => ['title' => 'Clothing, Footwear & Fashion Apparel', 'desc' => 'Fashion garments, shoes, sports apparel, caps, headwear.'],
            29 => ['title' => 'Processed Foods, Meats & Dairy', 'desc' => 'Edible oils, milk, cheese, poultry, preserved fruits and vegetables.'],
            30 => ['title' => 'Staples, Confectionery & Bakery', 'desc' => 'Coffee, tea, cocoa, rice, flour, bread, pastries, spices, chocolate.'],
            32 => ['title' => 'Beverages, Juices & Mineral Waters', 'desc' => 'Non-alcoholic drinks, carbonated soft drinks, fruit juices, beers.'],
            33 => ['title' => 'Wines & Alcoholic Spirits', 'desc' => 'Distilled spirits, wines, brandies, liqueurs (excluding beers).'],
            35 => ['title' => 'Advertising, Retail & Business Advisory', 'desc' => 'Branding agencies, retail chain operations, marketing, management consulting.'],
            36 => ['title' => 'Fintech, Banking & Real Estate', 'desc' => 'Digital wallets, insurance, banking, asset management, property brokerage.'],
            38 => ['title' => 'Telecommunications & Media Broadcast', 'desc' => 'Broadcasting, telecom carriers, satellite transmission, streaming infrastructure.'],
            39 => ['title' => 'Logistics, Delivery & Haulage', 'desc' => 'Freight transport, courier delivery, warehousing, cold-chain distribution.'],
            41 => ['title' => 'Education, Training & Entertainment', 'desc' => 'Academies, executive masterclasses, conferences, film & media production.'],
            42 => ['title' => 'Technology, SaaS & Design Practice', 'desc' => 'Software engineering, brand identity architecture, cloud hosting, UI/UX.'],
            43 => ['title' => 'Hospitality, Restaurants & Hotels', 'desc' => 'Cafes, fast-food franchises, catering, hotel & resort accommodation.'],
            44 => ['title' => 'Medical, Healthcare & Wellness', 'desc' => 'Hospitals, diagnostic labs, dental clinics, beauty spas, agriculture.'],
            45 => ['title' => 'Legal, Security & IP Licensing', 'desc' => 'Statutory legal representation, trademark licensing, personal & corporate security.'],
        ];

        return view('services.calculator', [
            'allPricing' => $allPricing,
            'niceClasses' => $niceClasses,
            'isMember' => $user && ($user->isMember() || $user->isAdmin()),
        ]);
    }
}
