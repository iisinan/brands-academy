<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationAcceptedMail;
use App\Mail\ApplicationStatusUpdatedMail;
use App\Mail\MemberWelcomeMail;
use App\Mail\PortfolioEvaluatedMail;
use App\Models\Certificate;
use App\Models\InstitutionalInquiry;
use App\Models\Member;
use App\Models\PortfolioSubmission;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopApplication;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Overview.
     */
    public function dashboard(): View
    {
        $stats = [
            'total_members' => Member::count(),
            'active_workshops' => Workshop::where('status', 'published')->count(),
            'pending_applications' => WorkshopApplication::where('status', 'pending')->count(),
            'total_certificates' => Certificate::count(),
            'pending_submissions' => PortfolioSubmission::where('status', 'submitted')->count(),
            'pending_inquiries' => InstitutionalInquiry::where('status', 'new')->count(),
            'total_inquiries' => InstitutionalInquiry::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'member_users' => User::where('role', 'member')->count(),
        ];

        $recentApplications = WorkshopApplication::with(['workshop', 'member'])
            ->latest()
            ->take(6)
            ->get();

        $workshops = Workshop::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentApplications', 'workshops'));
    }

    /**
     * Manage Members list.
     */
    public function members(Request $request): View
    {
        $query = Member::query()->with('user');

        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->where(function ($sub) use ($q): void {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('member_number', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $members = $query->latest()->paginate(15);

        return view('admin.members.index', compact('members'));
    }

    /**
     * Update member payment status (Approve bank transfer or mark paid/waived).
     */
    public function updateMemberPaymentStatus(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => ['required', 'string', 'in:paid,pending,under_review,waived'],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $status = $validated['payment_status'];

        if ($status === 'paid' || $status === 'waived') {
            $memberNumber = $member->member_number ?: Member::generateMemberNumber();

            $member->update([
                'member_number' => $memberNumber,
                'payment_status' => $status,
                'status' => 'active',
                'payment_method' => $member->payment_method ?? 'manual_approval',
                'paid_amount' => $member->paid_amount ?? $member->getFeeAmount(),
                'paid_at' => now(),
            ]);

            // Update associated pending payments
            $member->payments()->whereIn('status', ['pending', 'under_review'])->update([
                'status' => 'successful',
                'paid_at' => now(),
                'notes' => $validated['admin_notes'] ?? 'Approved by Administrator',
            ]);

            if ($member->user) {
                try {
                    Mail::to($member->user->email)->send(new MemberWelcomeMail($member->user));
                } catch (\Throwable $e) {
                    Log::warning('Welcome email delivery error on admin approval: '.$e->getMessage());
                }
            }

            return back()->with('success', "Member {$member->member_number} payment status updated to {$status}. Full portal access unlocked.");
        }

        $member->update([
            'payment_status' => $status,
        ]);

        return back()->with('success', "Member {$member->member_number} payment status updated to {$status}.");
    }

    /**
     * Manage Portal Users and RBAC roles.
     */
    public function users(Request $request): View
    {
        $query = User::query()->with('member');

        if ($request->filled('q')) {
            $q = (string) $request->query('q');
            $query->where(function ($sub) use ($q): void {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->query('role'));
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $roleCounts = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'member' => User::where('role', 'member')->count(),
        ];

        return view('admin.users.index', compact('users', 'roleCounts'));
    }

    /**
     * Update user RBAC role.
     */
    public function updateUserRole(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'in:admin,member'],
        ]);

        $user = User::findOrFail($id);

        // Security check: Prevent self-demotion
        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'For security, you cannot remove administrator privileges from your own active account.');
        }

        $oldRole = $user->role_label;
        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', "Role for {$user->name} has been updated from {$oldRole} to {$user->role_label} successfully.");
    }

    /**
     * Provision a new portal user account with designated RBAC role.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:admin,member'],
        ]);

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => trim($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // If provisioned as a member, ensure an initial Member profile exists
        if ($user->isMember()) {
            $nameParts = preg_split('/\s+/', $user->name, 2);
            Member::create([
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
                'qr_code_token' => (string) Str::uuid(),
                'joined_at' => now()->toDateString(),
            ]);
        }

        return back()->with('success', "Account for {$user->name} has been provisioned successfully with {$user->role_label} privileges.");
    }

    /**
     * Remove a user account.
     */
    public function destroyUser(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'For safety, you cannot delete your own active administrator account.');
        }

        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Cannot delete the only remaining system administrator.');
        }

        $userName = $user->name;
        $userRole = $user->role_label;
        $user->delete();

        return back()->with('success', "Account {$userName} ({$userRole}) was deleted successfully.");
    }

    /**
     * Export members list as CSV.
     */
    public function exportMembers(): StreamedResponse
    {
        $members = Member::orderBy('id', 'asc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="brands_academy_members_'.date('Y-m-d').'.csv"',
        ];

        return response()->stream(function () use ($members): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Member ID', 'Full Name', 'Email', 'Phone', 'Category', 'Organization', 'Designation', 'State', 'Country', 'Status', 'Joined Date']);

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->member_number,
                    $member->full_name,
                    $member->email,
                    $member->phone,
                    $member->category_label,
                    $member->institution_or_company,
                    $member->designation,
                    $member->state,
                    $member->country,
                    $member->status,
                    $member->joined_at->toDateString(),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Manage Workshops list.
     */
    public function workshops(): View
    {
        $workshops = Workshop::withCount('applications')->latest()->get();

        return view('admin.workshops.index', compact('workshops'));
    }

    /**
     * Show form to create new workshop.
     */
    public function createWorkshop(): View
    {
        return view('admin.workshops.create');
    }

    /**
     * Store new workshop.
     */
    public function storeWorkshop(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'track_type' => ['required', 'in:cba,cbs,cbe,community,executive,workshop'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'curriculum_topics' => ['nullable', 'string'],
            'delivery_mode' => ['required', 'in:online,in_person,hybrid'],
            'venue' => ['nullable', 'string', 'max:200'],
            'fee_type' => ['required', 'in:free,subsidized,paid'],
            'fee_amount' => ['nullable', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'application_starts_at' => ['required', 'date'],
            'application_deadline' => ['required', 'date', 'after:application_starts_at'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'instructor_name' => ['nullable', 'string', 'max:150'],
        ]);

        $topicsArray = [];
        if (! empty($validated['curriculum_topics'])) {
            $topicsArray = array_values(array_filter(array_map('trim', explode("\n", $validated['curriculum_topics']))));
        }

        Workshop::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(4),
            'track_type' => $validated['track_type'],
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'],
            'curriculum_topics' => $topicsArray,
            'delivery_mode' => $validated['delivery_mode'],
            'venue' => $validated['venue'] ?? null,
            'fee_type' => $validated['fee_type'],
            'fee_amount' => $validated['fee_amount'] ?? 0,
            'capacity' => $validated['capacity'] ?? null,
            'application_starts_at' => Carbon::parse($validated['application_starts_at']),
            'application_deadline' => Carbon::parse($validated['application_deadline']),
            'starts_at' => Carbon::parse($validated['starts_at']),
            'ends_at' => Carbon::parse($validated['ends_at']),
            'instructor_name' => $validated['instructor_name'] ?? null,
            'status' => 'published',
        ]);

        return redirect()->route('admin.workshops')->with('success', 'Workshop cohort created successfully with application window configured!');
    }

    /**
     * Show form to edit workshop cohort.
     */
    public function editWorkshop(int $id): View
    {
        $workshop = Workshop::findOrFail($id);

        return view('admin.workshops.edit', compact('workshop'));
    }

    /**
     * Update an existing workshop cohort.
     */
    public function updateWorkshop(Request $request, int $id): RedirectResponse
    {
        $workshop = Workshop::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'track_type' => ['required', 'in:cba,cbs,cbe,community,executive,workshop'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'curriculum_topics' => ['nullable', 'string'],
            'delivery_mode' => ['required', 'in:online,in_person,hybrid'],
            'venue' => ['nullable', 'string', 'max:200'],
            'fee_type' => ['required', 'in:free,subsidized,paid'],
            'fee_amount' => ['nullable', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'application_starts_at' => ['required', 'date'],
            'application_deadline' => ['required', 'date', 'after:application_starts_at'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'instructor_name' => ['nullable', 'string', 'max:150'],
            'status' => ['required', 'in:published,draft,archived'],
        ]);

        $topicsArray = [];
        if (! empty($validated['curriculum_topics'])) {
            $topicsArray = array_values(array_filter(array_map('trim', explode("\n", $validated['curriculum_topics']))));
        }

        $workshop->update([
            'title' => $validated['title'],
            'track_type' => $validated['track_type'],
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'],
            'curriculum_topics' => $topicsArray,
            'delivery_mode' => $validated['delivery_mode'],
            'venue' => $validated['venue'] ?? null,
            'fee_type' => $validated['fee_type'],
            'fee_amount' => $validated['fee_amount'] ?? 0,
            'capacity' => $validated['capacity'] ?? null,
            'application_starts_at' => Carbon::parse($validated['application_starts_at']),
            'application_deadline' => Carbon::parse($validated['application_deadline']),
            'starts_at' => Carbon::parse($validated['starts_at']),
            'ends_at' => Carbon::parse($validated['ends_at']),
            'instructor_name' => $validated['instructor_name'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.workshops')->with('success', "Workshop cohort '{$workshop->title}' updated successfully!");
    }

    /**
     * Applications management.
     */
    public function applications(Request $request): View
    {
        $query = WorkshopApplication::with(['workshop', 'member', 'certificate', 'portfolioSubmissions']);

        if ($request->filled('workshop_id')) {
            $query->where('workshop_id', $request->query('workshop_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $applications = $query->latest()->paginate(20);
        $workshops = Workshop::select('id', 'title')->get();

        return view('admin.applications.index', compact('applications', 'workshops'));
    }

    /**
     * Update application status.
     */
    public function updateApplicationStatus(Request $request, int $id): RedirectResponse
    {
        $application = WorkshopApplication::with('workshop')->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,accepted,waitlisted,rejected,completed'],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $previousStatus = $application->status;

        $application->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $application->admin_notes,
            'reviewed_at' => now(),
        ]);

        // If status changed to accepted, automatically dispatch admission offer email
        if ($validated['status'] === 'accepted' && $previousStatus !== 'accepted') {
            try {
                Mail::to($application->applicant_email)->send(new ApplicationAcceptedMail($application));
            } catch (\Throwable $e) {
                Log::warning('Offer email delivery notice: '.$e->getMessage());
            }
        } elseif (in_array($validated['status'], ['waitlisted', 'rejected']) && $previousStatus !== $validated['status']) {
            try {
                Mail::to($application->applicant_email)->send(new ApplicationStatusUpdatedMail($application, $validated['status']));
            } catch (\Throwable $e) {
                Log::warning("Status update email delivery notice ({$validated['status']}): ".$e->getMessage());
            }
        }

        return back()->with('success', "Application #{$application->id} updated to '{$application->status}'.");
    }

    /**
     * Issue and email certificate to an individual participant.
     */
    public function issueCertificate(int $applicationId): RedirectResponse
    {
        $application = WorkshopApplication::with('workshop', 'member')->findOrFail($applicationId);

        // Find or create Certificate
        $certificate = Certificate::firstOrCreate(
            ['workshop_application_id' => $application->id],
            [
                'certificate_number' => 'BANF-CERT-'.date('Y').'-'.strtoupper(Str::random(6)),
                'verification_token' => (string) Str::uuid(),
                'workshop_id' => $application->workshop_id,
                'member_id' => $application->member_id,
                'recipient_name' => $application->applicant_name,
                'recipient_email' => $application->applicant_email,
                'course_title' => $application->workshop->title,
                'track_tier' => $application->workshop->track_label,
                'issued_at' => now()->toDateString(),
                'email_status' => 'pending',
            ]
        );

        $application->update(['status' => 'completed']);

        // Dispatch Email with attached PDF certificate
        $certController = app(CertificateController::class);
        $certController->sendCertificateEmail($certificate);

        return back()->with('success', "Certificate #{$certificate->certificate_number} issued and emailed to {$certificate->recipient_email}!");
    }

    /**
     * Batch issue certificates to all accepted/graduated participants in a cohort.
     */
    public function bulkIssueCertificates(int $workshopId): RedirectResponse
    {
        $workshop = Workshop::findOrFail($workshopId);

        $applications = WorkshopApplication::where('workshop_id', $workshopId)
            ->whereIn('status', ['accepted', 'completed'])
            ->whereDoesntHave('certificate')
            ->get();

        if ($applications->isEmpty()) {
            return back()->with('error', 'No eligible candidates without certificates found in this cohort.');
        }

        $issuedCount = 0;
        $certController = app(CertificateController::class);

        foreach ($applications as $app) {
            $certificate = Certificate::create([
                'certificate_number' => 'BANF-CERT-'.date('Y').'-'.strtoupper(Str::random(6)),
                'verification_token' => (string) Str::uuid(),
                'workshop_id' => $workshop->id,
                'workshop_application_id' => $app->id,
                'member_id' => $app->member_id,
                'recipient_name' => $app->applicant_name,
                'recipient_email' => $app->applicant_email,
                'course_title' => $workshop->title,
                'track_tier' => $workshop->track_label,
                'issued_at' => now()->toDateString(),
                'email_status' => 'pending',
            ]);

            $app->update(['status' => 'completed']);
            $certController->sendCertificateEmail($certificate);
            $issuedCount++;
        }

        return back()->with('success', "Batch operation complete! {$issuedCount} official certificates generated and dispatched to graduates via email.");
    }

    /**
     * Portfolio submissions review list.
     */
    public function submissions(Request $request): View
    {
        $query = PortfolioSubmission::with(['workshop', 'application', 'member']);

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $submissions = $query->latest()->paginate(15);

        return view('admin.submissions.index', compact('submissions'));
    }

    /**
     * Grade & evaluate a practical portfolio submission.
     */
    public function evaluateSubmission(Request $request, int $id): RedirectResponse
    {
        $submission = PortfolioSubmission::with(['application', 'workshop'])->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:under_review,approved,revisions_requested'],
            'grade' => ['nullable', 'in:pass,merit,distinction'],
            'mentor_feedback' => ['required', 'string', 'max:1500'],
        ]);

        $submission->update([
            'status' => $validated['status'],
            'grade' => $validated['grade'] ?? null,
            'mentor_feedback' => $validated['mentor_feedback'],
            'reviewed_by' => auth()->user()->name,
            'reviewed_at' => now(),
        ]);

        // If approved, mark application as completed
        if ($validated['status'] === 'approved') {
            $submission->application->update(['status' => 'completed']);
        }

        // Dispatch mentor evaluation feedback email to student
        if (in_array($validated['status'], ['approved', 'revisions_requested']) && ! empty($submission->application?->applicant_email)) {
            try {
                Mail::to($submission->application->applicant_email)->send(new PortfolioEvaluatedMail($submission));
            } catch (\Throwable $e) {
                Log::warning('Portfolio feedback email notice: '.$e->getMessage());
            }
        }

        return back()->with('success', "Portfolio submission evaluated: Status updated to '{$submission->status}'. Feedback email dispatched to student.");
    }

    /**
     * Certificates management view.
     */
    public function certificates(): View
    {
        $certificates = Certificate::with(['workshop', 'member', 'application'])->latest()->paginate(20);

        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Export certificates registry as CSV.
     */
    public function exportCertificates(): StreamedResponse
    {
        $certificates = Certificate::with('workshop')->orderBy('id', 'asc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="brands_academy_certificates_'.date('Y-m-d').'.csv"',
        ];

        return response()->stream(function () use ($certificates): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Certificate Number', 'Recipient Name', 'Recipient Email', 'Course Title', 'Track Tier', 'Issue Date', 'Email Status', 'Verification URL']);

            foreach ($certificates as $cert) {
                fputcsv($handle, [
                    $cert->certificate_number,
                    $cert->recipient_name,
                    $cert->recipient_email,
                    $cert->course_title,
                    $cert->track_tier,
                    $cert->issued_at->toDateString(),
                    $cert->email_status,
                    route('verify.certificate', $cert->verification_token),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Institutional Inquiries list.
     */
    public function inquiries(Request $request): View
    {
        $query = InstitutionalInquiry::query();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->where(function ($sub) use ($q): void {
                $sub->where('organization_name', 'like', "%{$q}%")
                    ->orWhere('contact_person', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $inquiries = $query->latest()->paginate(15);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Update institutional inquiry status and notes.
     */
    public function updateInquiryStatus(Request $request, int $id): RedirectResponse
    {
        $inquiry = InstitutionalInquiry::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,in_discussion,partnered,closed'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $inquiry->update($validated);

        return back()->with('success', "Inquiry from {$inquiry->organization_name} updated successfully.");
    }
}
