<?php

namespace App\Http\Controllers;

use App\Mail\InstitutionalInquiryMail;
use App\Models\InstitutionalInquiry;
use App\Models\Member;
use App\Models\Workshop;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): View
    {
        $openWorkshops = Workshop::query()
            ->where('status', 'published')
            ->where('application_starts_at', '<=', now())
            ->where('application_deadline', '>=', now())
            ->orderBy('application_deadline', 'asc')
            ->take(3)
            ->get();

        $allWorkshops = Workshop::query()
            ->where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderBy('application_starts_at', 'asc')
            ->take(6)
            ->get();

        $stats = [
            'total_members' => Member::count(),
            'active_cohorts' => Workshop::where('status', 'published')->count(),
            'governance_board' => 4,
            'cac_number' => '7344471',
        ];

        return view('home', compact('openWorkshops', 'allWorkshops', 'stats'));
    }

    /**
     * Show the institutional credential, manifesto, and governance page.
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Show the Code of Ethics & Professional Charter.
     */
    public function ethics(): View
    {
        return view('legal.ethics');
    }

    /**
     * Show the Privacy Policy (NDPA 2023).
     */
    public function privacy(): View
    {
        return view('legal.privacy');
    }

    /**
     * Show the Terms of Use & Refund Policy.
     */
    public function terms(): View
    {
        return view('legal.terms');
    }

    /**
     * Show the 3-Tier Professional Certification Framework page (CBA, CBS, CBE).
     */
    public function certifications(): View
    {
        $cbaWorkshops = Workshop::where('status', 'published')
            ->where('track_type', 'cba')
            ->orderBy('application_deadline', 'asc')
            ->get();

        $cbsWorkshops = Workshop::where('status', 'published')
            ->where('track_type', 'cbs')
            ->orderBy('application_deadline', 'asc')
            ->get();

        return view('certifications.index', compact('cbaWorkshops', 'cbsWorkshops'));
    }

    /**
     * Submit an expression of interest / waitlist application for certification tracks (e.g. CBE 2027).
     */
    public function registerInterest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tier' => ['required', 'string', 'in:CBA,CBS,CBE'],
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'organization' => ['required', 'string', 'max:200'],
            'job_title' => ['required', 'string', 'max:150'],
            'experience_years' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1500'],
        ]);

        $inquiry = InstitutionalInquiry::create([
            'organization_name' => $validated['organization'],
            'contact_person' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'organization_type' => 'corporate',
            'solution_interest' => 'strategic_advisory',
            'estimated_cohort_size' => 1,
            'target_timeline' => $validated['tier'] === 'CBE' ? '2027 Cohort' : 'Next Available Cohort',
            'message' => sprintf(
                "[Expression of Interest: %s Track]\nRole: %s\nExperience: %s\nNotes: %s",
                $validated['tier'],
                $validated['job_title'],
                $validated['experience_years'],
                $validated['notes'] ?? 'None provided'
            ),
        ]);

        try {
            Mail::to($inquiry->email)->send(new InstitutionalInquiryMail($inquiry, isInternalAlert: false));

            $adminEmail = config('mail.from.address');
            if ($adminEmail && $adminEmail !== $inquiry->email) {
                Mail::to($adminEmail)->send(new InstitutionalInquiryMail($inquiry, isInternalAlert: true));
            }
        } catch (\Throwable $e) {
            Log::warning('Could not dispatch certification interest email: '.$e->getMessage());
        }

        $tierLabel = match ($validated['tier']) {
            'CBE' => 'Certified Brand Executive (CBE) 2027 inaugural cohort',
            'CBS' => 'Certified Brand Strategist (CBS) upcoming cohort',
            default => 'Certified Brand Associate (CBA) upcoming cohort',
        };

        return back()->with('success', "Thank you! Your expression of interest for the {$tierLabel} has been recorded. Our admissions committee will reach out with syllabus briefings and priority registration.");
    }
}
