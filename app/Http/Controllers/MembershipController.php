<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PortfolioSubmission;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    /**
     * Show the ongoing membership registration form.
     */
    public function create(): View
    {
        return view('membership.register');
    }

    /**
     * Process ongoing membership registration.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('name') && (! $request->filled('first_name') || ! $request->filled('last_name'))) {
            $parts = preg_split('/\s+/', trim((string) $request->input('name')), 2);
            $firstName = $parts[0] ?? 'Member';
            $lastName = $parts[1] ?? $parts[0] ?? 'User';
            $request->merge([
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:200'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'unique:members,email'],
            'phone' => ['required', 'string', 'max:25'],
            'category' => ['required', 'in:student,professional,corporate,fellow'],
            'institution_or_company' => ['nullable', 'string', 'max:200'],
            'designation' => ['nullable', 'string', 'max:150'],
            'state' => ['required', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $fullName = ! empty($validated['name']) ? trim($validated['name']) : "{$validated['first_name']} {$validated['last_name']}";

        // 1. Create User login account
        $user = User::create([
            'name' => $fullName,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'member',
        ]);

        // 2. Create Member Profile
        $member = Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-'.date('Y').'-'.strtoupper(Str::random(5)),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'category' => $validated['category'],
            'institution_or_company' => $validated['institution_or_company'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'state' => $validated['state'],
            'country' => $validated['country'] ?? 'Nigeria',
            'status' => 'active',
            'bio' => $validated['bio'] ?? null,
            'qr_code_token' => (string) Str::uuid(),
            'joined_at' => now()->toDateString(),
        ]);

        // 3. Log user into portal
        Auth::login($user);

        return redirect()->route('member.dashboard')->with('success', "Welcome to Brands Academy Nigeria Foundation! Your official Member ID is {$member->member_number}.");
    }

    /**
     * Member Dashboard view.
     */
    public function dashboard(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Please sign in to access your member dashboard.');
        }

        $member = $user->member;

        // If user has no member profile yet, create one from user details
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
                'qr_code_token' => (string) Str::uuid(),
                'joined_at' => now()->toDateString(),
            ]);
        }

        $openWorkshops = Workshop::query()
            ->where('status', 'published')
            ->where('application_starts_at', '<=', now())
            ->where('application_deadline', '>=', now())
            ->orderBy('application_deadline', 'asc')
            ->get();

        $applications = $member->applications()
            ->with(['workshop', 'portfolioSubmissions'])
            ->orderBy('created_at', 'desc')
            ->get();

        $certificates = $member->certificates()
            ->with('workshop')
            ->orderBy('issued_at', 'desc')
            ->get();

        return view('membership.dashboard', compact('member', 'openWorkshops', 'applications', 'certificates'));
    }

    /**
     * Update Member profile information.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $member = $user->member;

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:25'],
            'institution_or_company' => ['nullable', 'string', 'max:200'],
            'designation' => ['nullable', 'string', 'max:150'],
            'state' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $member->update($validated);

        return back()->with('success', 'Your member profile has been updated successfully.');
    }

    /**
     * Show portfolio project submission form for an accepted cohort application.
     */
    public function submitPortfolio(int $applicationId): View|RedirectResponse
    {
        $user = Auth::user();
        $member = $user->member;

        $application = WorkshopApplication::with(['workshop', 'portfolioSubmissions'])
            ->where('id', $applicationId)
            ->where(function ($q) use ($user, $member): void {
                $q->where('user_id', $user->id)
                    ->orWhere('member_id', $member?->id);
            })
            ->firstOrFail();

        return view('membership.submit-portfolio', compact('application'));
    }

    /**
     * Store submitted portfolio deliverables.
     */
    public function storePortfolio(Request $request, int $applicationId): RedirectResponse
    {
        $user = Auth::user();
        $member = $user->member;

        $application = WorkshopApplication::with('workshop')
            ->where('id', $applicationId)
            ->where(function ($q) use ($user, $member): void {
                $q->where('user_id', $user->id)
                    ->orWhere('member_id', $member?->id);
            })
            ->firstOrFail();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:30'],
            'deck_url' => ['required', 'url', 'max:255'],
            'deliverables' => ['nullable', 'string'],
        ]);

        $deliverablesArray = [];
        if (! empty($validated['deliverables'])) {
            $deliverablesArray = array_values(array_filter(array_map('trim', explode("\n", $validated['deliverables']))));
        }

        PortfolioSubmission::create([
            'workshop_application_id' => $application->id,
            'workshop_id' => $application->workshop_id,
            'member_id' => $member?->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deck_url' => $validated['deck_url'],
            'deliverables' => $deliverablesArray,
            'status' => 'submitted',
        ]);

        return redirect()->route('member.dashboard')->with('success', "Portfolio project '{$validated['title']}' submitted successfully! Our mentors will review your deliverables.");
    }

    /**
     * Public Digital Membership Card view.
     */
    public function card(string $token): View
    {
        $member = Member::where('qr_code_token', $token)->firstOrFail();

        return view('membership.card', compact('member'));
    }
}
