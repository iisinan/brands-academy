<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use App\Models\WebinarQuestion;
use App\Models\WebinarRegistration;
use App\Services\Video\VideoMeetingManager;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class WebinarController extends Controller
{
    public function __construct(
        protected VideoMeetingManager $videoManager
    ) {}

    /**
     * Public Webinars listing.
     */
    public function index(): View
    {
        $upcomingWebinars = Webinar::where('is_published', true)
            ->where('starts_at', '>=', Carbon::now()->subHours(2))
            ->orderBy('starts_at')
            ->withCount('registrations')
            ->get();

        $pastWebinars = Webinar::where('is_published', true)
            ->where('starts_at', '<', Carbon::now()->subHours(2))
            ->orderByDesc('starts_at')
            ->withCount('registrations')
            ->paginate(6);

        return view('webinars.index', compact('upcomingWebinars', 'pastWebinars'));
    }

    /**
     * Public Webinar Detail & Registration.
     */
    public function show(Request $request, string $slug): View
    {
        $webinar = Webinar::where('slug', $slug)
            ->where('is_published', true)
            ->withCount('registrations')
            ->firstOrFail();

        $user = $request->user();
        $isRegistered = false;
        $registration = null;

        if ($user) {
            $registration = WebinarRegistration::where('webinar_id', $webinar->id)
                ->where('user_id', $user->id)
                ->first();
            $isRegistered = (bool) $registration;
        }

        $fee = $webinar->calculateFeeFor($user);
        $isDiscounted = $user && ($user->isMember() || $user->isAdmin()) && $webinar->fee_type !== 'free' && $webinar->regular_price > $fee;

        $questions = $webinar->questions()->take(10)->get();

        return view('webinars.show', compact('webinar', 'isRegistered', 'registration', 'fee', 'isDiscounted', 'questions'));
    }

    /**
     * Handle Webinar Registration (Free or Paid).
     */
    public function register(Request $request, string $slug): RedirectResponse
    {
        $webinar = Webinar::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $user = $request->user();

        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:150',
        ];

        $validated = $request->validate($rules);
        $email = strtolower($validated['email']);

        // Check if already registered
        $existing = WebinarRegistration::where('webinar_id', $webinar->id)
            ->where('email', $email)
            ->first();

        if ($existing) {
            return back()->with('info', 'You are already registered for this webinar! A calendar invite and Google Meet link have been prepared for you.');
        }

        $fee = $webinar->calculateFeeFor($user);

        $registration = WebinarRegistration::create([
            'webinar_id' => $webinar->id,
            'user_id' => $user?->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $email,
            'phone' => $validated['phone'] ?? null,
            'organization' => $validated['organization'] ?? null,
            'amount_paid' => $fee,
            'payment_gateway' => $fee > 0 ? 'online' : 'free',
            'payment_reference' => $fee > 0 ? 'WBN-PAY-'.strtoupper(Str::random(10)) : null,
        ]);

        return redirect()->route('webinars.show', $webinar->slug)
            ->with('success', 'RSVP confirmed! We look forward to seeing you. You can download your calendar invite below.');
    }

    /**
     * Download Standard iCalendar (.ics) invite.
     */
    public function calendar(string $slug): Response
    {
        $webinar = Webinar::where('slug', $slug)->firstOrFail();

        $dtStart = $webinar->starts_at->format('Ymd\THis\Z');
        $dtEnd = $webinar->starts_at->copy()->addMinutes($webinar->duration_minutes)->format('Ymd\THis\Z');
        $summary = addcslashes($webinar->title, ',;');
        $description = addcslashes($webinar->summary ?: $webinar->title, ',;').'\n\nJoin Google Meet: '.($webinar->meeting_link ?: 'https://meet.google.com');
        $location = $webinar->meeting_link ?: 'Google Meet Virtual Room';

        $ics = "BEGIN:VCALENDAR\r\n".
            "VERSION:2.0\r\n".
            "PRODID:-//Brands Academy Nigeria Foundation//Webinar Calendar//EN\r\n".
            "CALSCALE:GREGORIAN\r\n".
            "METHOD:PUBLISH\r\n".
            "BEGIN:VEVENT\r\n".
            "UID:webinar-{$webinar->id}@brandsacademy.org.ng\r\n".
            'DTSTAMP:'.gmdate('Ymd\THis\Z')."\r\n".
            "DTSTART:{$dtStart}\r\n".
            "DTEND:{$dtEnd}\r\n".
            "SUMMARY:{$summary}\r\n".
            "DESCRIPTION:{$description}\r\n".
            "LOCATION:{$location}\r\n".
            "STATUS:CONFIRMED\r\n".
            "END:VEVENT\r\n".
            "END:VCALENDAR\r\n";

        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="webinar-'.$webinar->slug.'.ics"',
        ]);
    }

    /**
     * Submit an advance question for the speaker.
     */
    public function submitQuestion(Request $request, string $slug): RedirectResponse
    {
        $webinar = Webinar::where('slug', $slug)->firstOrFail();
        $user = $request->user();

        $validated = $request->validate([
            'attendee_name' => ['required', 'string', 'max:150'],
            'attendee_organization' => ['nullable', 'string', 'max:150'],
            'question' => ['required', 'string', 'min:8', 'max:1000'],
        ]);

        WebinarQuestion::create([
            'webinar_id' => $webinar->id,
            'user_id' => $user?->id,
            'attendee_name' => $validated['attendee_name'],
            'attendee_organization' => $validated['attendee_organization'] ?? null,
            'question' => $validated['question'],
        ]);

        return back()->with('success', 'Your question has been submitted for the session speakers.');
    }

    /**
     * Upvote a question.
     */
    public function upvoteQuestion(Request $request, string $slug, int $questionId): JsonResponse|RedirectResponse
    {
        $question = WebinarQuestion::where('id', $questionId)->firstOrFail();
        $question->increment('upvotes_count');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'upvotes_count' => $question->fresh()->upvotes_count,
            ]);
        }

        return back()->with('success', 'Upvoted question.');
    }
}
