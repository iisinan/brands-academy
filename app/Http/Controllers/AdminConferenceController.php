<?php

namespace App\Http\Controllers;

use App\Models\CallForPaper;
use App\Models\Conference;
use App\Models\ConferenceDelegate;
use App\Models\ConferenceTicket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminConferenceController extends Controller
{
    /**
     * Admin Conferences Management.
     */
    public function index(): View
    {
        $conferences = Conference::withCount(['tickets', 'delegates', 'papers'])
            ->orderBy('starts_at', 'desc')
            ->paginate(10);

        return view('admin.conferences.index', [
            'conferences' => $conferences,
        ]);
    }

    /**
     * Store new Conference & Default Tickets.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'theme' => ['nullable', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:2025', 'max:2035'],
            'venue' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'description' => ['nullable', 'string'],
            'cfp_open' => ['nullable', 'boolean'],
        ]);

        $validated['cfp_open'] = $request->has('cfp_open');

        $conference = Conference::create($validated);

        // Seed 3 standard tiered passes
        ConferenceTicket::create([
            'conference_id' => $conference->id,
            'name' => 'Student Delegate',
            'regular_price' => 15000.00,
            'member_price' => 11250.00,
            'quantity_available' => 100,
            'benefits' => ['Access to all plenary halls', 'Digital certificate of participation', 'Summit program pack'],
        ]);

        ConferenceTicket::create([
            'conference_id' => $conference->id,
            'name' => 'General Delegate Pass',
            'regular_price' => 35000.00,
            'member_price' => 26250.00,
            'quantity_available' => 300,
            'benefits' => ['Full summit access', 'Conference delegate bag & materials', 'Buffet lunch & networking tea breaks', 'Certificate of attendance'],
        ]);

        ConferenceTicket::create([
            'conference_id' => $conference->id,
            'name' => 'VIP & Corporate Delegation',
            'regular_price' => 85000.00,
            'member_price' => 63750.00,
            'quantity_available' => 50,
            'benefits' => ['Reserved VIP front-row seating', 'Exclusive Executive Networking Lounge', 'Gala Dinner & Awards seat', 'Printed JBSM Journal volume'],
        ]);

        return redirect()->route('admin.conferences.show', $conference->id)
            ->with('success', 'Conference created with default ticket passes!');
    }

    /**
     * Show conference management studio.
     */
    public function show(int $id): View
    {
        $conference = Conference::with(['tickets', 'delegates.ticket', 'papers'])
            ->withCount(['delegates', 'papers'])
            ->findOrFail($id);

        return view('admin.conferences.show', [
            'conference' => $conference,
        ]);
    }

    /**
     * Check-in delegate at conference venue.
     */
    public function toggleCheckIn(int $delegateId): RedirectResponse
    {
        $delegate = ConferenceDelegate::findOrFail($delegateId);
        $delegate->update([
            'checked_in' => ! $delegate->checked_in,
            'checked_in_at' => ! $delegate->checked_in ? now() : null,
        ]);

        return back()->with('success', "Check-in status updated for {$delegate->full_name}.");
    }

    /**
     * Review Call for Papers Abstract.
     */
    public function reviewCfp(Request $request, int $id): RedirectResponse
    {
        $paper = CallForPaper::findOrFail($id);

        $validated = $request->validate([
            'review_status' => ['required', 'string', 'in:submitted,under_review,accepted_presentation,accepted_poster,rejected'],
            'reviewer_feedback' => ['nullable', 'string', 'max:2000'],
        ]);

        $paper->update($validated);

        return back()->with('success', "Abstract review status updated for '{$paper->title}'.");
    }

    /**
     * Export delegates list to CSV.
     */
    public function exportDelegates(int $id): StreamedResponse
    {
        $conference = Conference::findOrFail($id);
        $delegates = $conference->delegates()->with('ticket')->get();
        $filename = 'delegates-'.$conference->slug.'.csv';

        return response()->streamDownload(function () use ($delegates): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Badge Code',
                'Delegate Name',
                'Email',
                'Phone',
                'Organization',
                'Designation',
                'Ticket Category',
                'Fee Paid (NGN)',
                'Checked In',
                'Registered At',
            ]);

            foreach ($delegates as $d) {
                fputcsv($handle, [
                    $d->badge_code,
                    $d->full_name,
                    $d->email,
                    $d->phone,
                    $d->organization,
                    $d->designation,
                    $d->ticket ? $d->ticket->name : 'General',
                    $d->amount_paid,
                    $d->checked_in ? 'Yes' : 'No',
                    $d->created_at->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
