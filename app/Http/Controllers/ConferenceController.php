<?php

namespace App\Http\Controllers;

use App\Models\CallForPaper;
use App\Models\Conference;
use App\Models\ConferenceDelegate;
use App\Models\ConferenceTicket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConferenceController extends Controller
{
    /**
     * Public Conferences & Brand Summits.
     */
    public function index(): View
    {
        $upcoming = Conference::where('is_active', true)
            ->where('ends_at', '>=', now())
            ->with(['tickets'])
            ->orderBy('starts_at', 'asc')
            ->get();

        $past = Conference::where('is_active', true)
            ->where('ends_at', '<', now())
            ->orderBy('starts_at', 'desc')
            ->paginate(6);

        return view('conferences.index', [
            'upcoming' => $upcoming,
            'past' => $past,
        ]);
    }

    /**
     * Conference Detail & Registration Hub.
     */
    public function show(string $slug): View
    {
        $conference = Conference::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'tickets' => function ($q): void {
                    $q->orderBy('regular_price', 'asc');
                },
                'schedules' => function ($q): void {
                    $q->orderBy('day_number')->orderBy('start_time');
                },
            ])
            ->firstOrFail();

        return view('conferences.show', [
            'conference' => $conference,
        ]);
    }

    /**
     * Delegate Ticket Registration & Checkout.
     */
    public function register(Request $request, string $slug): RedirectResponse
    {
        $conference = Conference::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'ticket_id' => ['required', 'exists:conference_tickets,id'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'organization' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
        ]);

        $ticket = ConferenceTicket::where('id', $validated['ticket_id'])
            ->where('conference_id', $conference->id)
            ->firstOrFail();

        if ($ticket->isSoldOut()) {
            return back()->with('error', 'The selected ticket category is sold out.');
        }

        $user = $request->user();
        $fee = $ticket->calculatePriceFor($user);
        $reference = 'CONF-'.strtoupper(Str::random(10));

        $delegate = ConferenceDelegate::create([
            'conference_id' => $conference->id,
            'ticket_id' => $ticket->id,
            'user_id' => $user?->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'organization' => $validated['organization'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'amount_paid' => $fee,
            'payment_reference' => $reference,
            'checked_in' => false,
        ]);

        $ticket->increment('quantity_sold');

        return redirect()->route('conferences.badge', $delegate->badge_code)
            ->with('success', "Registration confirmed for {$conference->title}! Your digital delegate pass is ready.");
    }

    /**
     * Digital Delegate Badge & Public Verification.
     */
    public function badge(string $badgeCode): View
    {
        $delegate = ConferenceDelegate::where('badge_code', $badgeCode)
            ->with(['conference', 'ticket'])
            ->firstOrFail();

        return view('conferences.badge', [
            'delegate' => $delegate,
            'conference' => $delegate->conference,
        ]);
    }

    /**
     * Call for Papers (CFP) Abstract Submission View.
     */
    public function cfp(string $slug): View
    {
        $conference = Conference::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('conferences.cfp', [
            'conference' => $conference,
        ]);
    }

    /**
     * Process Call for Papers Submission.
     */
    public function submitCfp(Request $request, string $slug): RedirectResponse
    {
        $conference = Conference::where('slug', $slug)->firstOrFail();

        if (! $conference->cfp_open) {
            return back()->with('error', 'Call for Papers for this summit is currently closed.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:300'],
            'author_name' => ['required', 'string', 'max:200'],
            'author_email' => ['required', 'email', 'max:255'],
            'author_institution' => ['required', 'string', 'max:255'],
            'abstract_text' => ['required', 'string', 'min:100', 'max:4000'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'manuscript_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:15360'],
        ]);

        $pdfPath = null;
        if ($request->hasFile('manuscript_pdf')) {
            $pdfPath = $request->file('manuscript_pdf')->store('conference/cfp', 'public');
        }

        CallForPaper::create([
            'conference_id' => $conference->id,
            'user_id' => $request->user()?->id,
            'title' => $validated['title'],
            'author_name' => $validated['author_name'],
            'author_email' => $validated['author_email'],
            'author_institution' => $validated['author_institution'],
            'abstract_text' => $validated['abstract_text'],
            'keywords' => $validated['keywords'] ?? null,
            'manuscript_pdf_path' => $pdfPath,
            'review_status' => CallForPaper::STATUS_SUBMITTED,
        ]);

        return redirect()->route('conferences.show', $conference->slug)
            ->with('success', 'Your abstract and paper submission has been received by the Scientific Committee.');
    }
}
