<?php

namespace App\Http\Controllers;

use App\Mail\InstitutionalInquiryMail;
use App\Models\InstitutionalInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PartnershipController extends Controller
{
    /**
     * Show the Institutional Partnerships & Licensing overview.
     */
    public function index(): View
    {
        return view('partnerships');
    }

    /**
     * Process an institutional / corporate inquiry.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:200'],
            'contact_person' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'organization_type' => ['required', 'in:corporate,higher_education,government,ngo,other'],
            'solution_interest' => ['required', 'in:staff_training,curriculum_licensing,strategic_advisory,community_sponsorship'],
            'estimated_cohort_size' => ['nullable', 'integer', 'min:1'],
            'target_timeline' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
        ]);

        $inquiry = InstitutionalInquiry::create($validated);

        try {
            Mail::to($inquiry->email)->send(new InstitutionalInquiryMail($inquiry, isInternalAlert: false));

            $adminEmail = config('mail.from.address');
            if ($adminEmail && $adminEmail !== $inquiry->email) {
                Mail::to($adminEmail)->send(new InstitutionalInquiryMail($inquiry, isInternalAlert: true));
            }
        } catch (\Throwable $e) {
            Log::warning('Could not dispatch inquiry email: '.$e->getMessage());
        }

        return back()->with('success', 'Thank you for contacting Brands Academy Nigeria Foundation. Our institutional partnership team will review your requirements and reach out within 48 hours.');
    }

    /**
     * Show the Foundation Faculty, Leadership & Mentors page.
     */
    public function faculty(): View
    {
        return view('faculty');
    }
}
