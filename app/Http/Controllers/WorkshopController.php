<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationReceivedMail;
use App\Models\Workshop;
use App\Models\WorkshopApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WorkshopController extends Controller
{
    /**
     * Display a listing of workshops and cohorts with application status filters.
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status', 'all');
        $trackFilter = $request->query('track', 'all');

        $query = Workshop::query()->where('status', 'published');

        if ($statusFilter === 'open') {
            $query->where('application_starts_at', '<=', now())
                ->where('application_deadline', '>=', now());
        } elseif ($statusFilter === 'upcoming') {
            $query->where('application_starts_at', '>', now());
        } elseif ($statusFilter === 'closed') {
            $query->where('application_deadline', '<', now());
        }

        if (in_array($trackFilter, ['cba', 'cbs', 'cbe', 'community', 'executive', 'workshop'])) {
            $query->where('track_type', $trackFilter);
        }

        $workshops = $query->orderBy('application_deadline', 'asc')->get();

        $baseCountQuery = fn () => Workshop::where('status', 'published')
            ->when(in_array($trackFilter, ['cba', 'cbs', 'cbe', 'community', 'executive', 'workshop']), fn ($q) => $q->where('track_type', $trackFilter));

        $counts = [
            'all' => $baseCountQuery()->count(),
            'open' => $baseCountQuery()->where('application_starts_at', '<=', now())->where('application_deadline', '>=', now())->count(),
            'upcoming' => $baseCountQuery()->where('application_starts_at', '>', now())->count(),
            'closed' => $baseCountQuery()->where('application_deadline', '<', now())->count(),
        ];

        return view('workshops.index', compact('workshops', 'statusFilter', 'trackFilter', 'counts'));
    }

    /**
     * Display the specified workshop details and application window.
     */
    public function show(string $slug): View
    {
        $workshop = Workshop::where('slug', $slug)->firstOrFail();

        $alreadyApplied = false;
        $existingApplication = null;

        if (Auth::check()) {
            $existingApplication = WorkshopApplication::where('workshop_id', $workshop->id)
                ->where(function ($q): void {
                    $q->where('user_id', Auth::id())
                        ->orWhere('applicant_email', Auth::user()->email);
                })
                ->first();

            $alreadyApplied = $existingApplication !== null;
        }

        return view('workshops.show', compact('workshop', 'alreadyApplied', 'existingApplication'));
    }

    /**
     * Process an application for an open cohort.
     */
    public function apply(Request $request, string $slug): RedirectResponse
    {
        $workshop = Workshop::where('slug', $slug)->firstOrFail();

        // Enforce application window constraint
        if (! $workshop->isOpenForApplications()) {
            return back()->with('error', 'Applications for this programme cohort are currently closed or not yet open.');
        }

        $user = Auth::user();
        $member = $user?->member;

        // If applicant is an authenticated member, auto-populate details from their member profile
        if ($user && $member) {
            $request->merge([
                'applicant_name' => $request->input('applicant_name', $member->full_name ?: $user->name),
                'applicant_email' => $request->input('applicant_email', $member->email ?: $user->email),
                'applicant_phone' => $request->input('applicant_phone', $member->phone ?? '+234 800 000 0000'),
                'applicant_organization' => $request->input('applicant_organization', $member->institution_or_company),
            ]);
        }

        $validated = $request->validate([
            'applicant_name' => ['required', 'string', 'max:150'],
            'applicant_email' => ['required', 'string', 'email', 'max:255'],
            'applicant_phone' => ['required', 'string', 'max:25'],
            'applicant_organization' => ['nullable', 'string', 'max:200'],
            'statement_of_purpose' => ['required', 'string', 'min:3', 'max:2000'],
            'portfolio_link' => ['nullable', 'url', 'max:255'],
            'scholarship_requested' => ['nullable', 'boolean'],
            'scholarship_reason' => ['nullable', 'string', 'max:1000'],
        ], [
            'statement_of_purpose.required' => 'Please provide a statement of purpose or your learning goals.',
            'statement_of_purpose.min' => 'Please provide at least 3 characters for your statement of purpose.',
            'portfolio_link.url' => 'The portfolio link must be a valid URL (e.g. https://behance.net/yourprofile).',
        ]);

        // Prevent duplicate application
        $existsQuery = WorkshopApplication::where('workshop_id', $workshop->id)
            ->where(function ($q) use ($validated, $user, $member): void {
                $q->where('applicant_email', $validated['applicant_email']);
                if ($user) {
                    $q->orWhere('user_id', $user->id);
                }
                if ($member) {
                    $q->orWhere('member_id', $member->id);
                }
            });

        if ($existsQuery->exists()) {
            return back()->with('error', 'An application has already been submitted for this cohort.');
        }

        $application = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'member_id' => $member?->id,
            'user_id' => $user?->id,
            'applicant_name' => $validated['applicant_name'],
            'applicant_email' => $validated['applicant_email'],
            'applicant_phone' => $validated['applicant_phone'],
            'applicant_organization' => $validated['applicant_organization'] ?? null,
            'statement_of_purpose' => $validated['statement_of_purpose'],
            'portfolio_link' => $validated['portfolio_link'] ?? null,
            'scholarship_requested' => (bool) ($validated['scholarship_requested'] ?? false),
            'scholarship_reason' => $validated['scholarship_reason'] ?? null,
            'status' => 'pending',
        ]);

        try {
            Mail::to($application->applicant_email)->send(new ApplicationReceivedMail($application));
        } catch (\Throwable $e) {
            Log::warning("Could not dispatch application receipt email to {$application->applicant_email}: ".$e->getMessage());
        }

        $discountNotice = ($member && $workshop->fee_type !== 'free')
            ? ' as a Registered Member with your 25% tuition discount applied (Tuition: ₦'.number_format($workshop->member_fee_amount).')'
            : '';

        return redirect()->route('workshops.show', $workshop->slug)
            ->with('success', "Your application for '{$workshop->title}' has been submitted successfully{$discountNotice}! A confirmation receipt has been sent to {$application->applicant_email}.");
    }
}
