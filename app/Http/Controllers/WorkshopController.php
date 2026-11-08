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

        $query = Workshop::query()->where('status', 'published');

        if ($statusFilter === 'open') {
            $query->where('application_starts_at', '<=', now())
                ->where('application_deadline', '>=', now());
        } elseif ($statusFilter === 'upcoming') {
            $query->where('application_starts_at', '>', now());
        } elseif ($statusFilter === 'closed') {
            $query->where('application_deadline', '<', now());
        }

        $workshops = $query->orderBy('application_deadline', 'asc')->get();

        $counts = [
            'all' => Workshop::where('status', 'published')->count(),
            'open' => Workshop::where('status', 'published')->where('application_starts_at', '<=', now())->where('application_deadline', '>=', now())->count(),
            'upcoming' => Workshop::where('status', 'published')->where('application_starts_at', '>', now())->count(),
            'closed' => Workshop::where('status', 'published')->where('application_deadline', '<', now())->count(),
        ];

        return view('workshops.index', compact('workshops', 'statusFilter', 'counts'));
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

        $validated = $request->validate([
            'applicant_name' => ['required', 'string', 'max:150'],
            'applicant_email' => ['required', 'string', 'email', 'max:255'],
            'applicant_phone' => ['required', 'string', 'max:25'],
            'applicant_organization' => ['nullable', 'string', 'max:200'],
            'statement_of_purpose' => ['required', 'string', 'min:30', 'max:2000'],
            'portfolio_link' => ['nullable', 'url', 'max:255'],
            'scholarship_requested' => ['nullable', 'boolean'],
            'scholarship_reason' => ['nullable', 'string', 'max:1000'],
        ]);

        // Prevent duplicate application
        $exists = WorkshopApplication::where('workshop_id', $workshop->id)
            ->where('applicant_email', $validated['applicant_email'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'An application has already been submitted for this email address and cohort.');
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

        return redirect()->route('workshops.show', $workshop->slug)->with('success', "Your application for '{$workshop->title}' has been submitted successfully! A confirmation receipt has been sent to {$application->applicant_email}.");
    }
}
