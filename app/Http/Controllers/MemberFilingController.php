<?php

namespace App\Http\Controllers;

use App\Models\ServiceFiling;
use App\Services\LegalDeskService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberFilingController extends Controller
{
    public function __construct(
        protected LegalDeskService $legalDeskService
    ) {}

    /**
     * Display the member's legal filings.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $filings = ServiceFiling::where(function ($query) use ($user): void {
            $query->where('user_id', $user->id);
            if ($user->member) {
                $query->orWhere('member_id', $user->member->id);
            }
        })
            ->withCount('documents')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('membership.filings.index', [
            'filings' => $filings,
            'user' => $user,
        ]);
    }

    /**
     * Show detailed filing case progress and interactive portal.
     */
    public function show(Request $request, string $trackingCode): View
    {
        $user = $request->user();

        $filing = ServiceFiling::where('tracking_code', $trackingCode)
            ->where(function ($query) use ($user): void {
                $query->where('user_id', $user->id);
                if ($user->member) {
                    $query->orWhere('member_id', $user->member->id);
                }
            })
            ->with(['documents', 'statusLogs.changedByUser'])
            ->firstOrFail();

        return view('membership.filings.show', [
            'filing' => $filing,
        ]);
    }

    /**
     * Client upload for queried documents or additional evidence.
     */
    public function uploadDocument(Request $request, string $trackingCode): RedirectResponse
    {
        $user = $request->user();

        $filing = ServiceFiling::where('tracking_code', $trackingCode)
            ->where(function ($query) use ($user): void {
                $query->where('user_id', $user->id);
                if ($user->member) {
                    $query->orWhere('member_id', $user->member->id);
                }
            })
            ->firstOrFail();

        $validated = $request->validate([
            'document_type' => ['required', 'string', 'max:50'],
            'document_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,zip,doc,docx', 'max:15360'],
            'client_comment' => ['nullable', 'string', 'max:500'],
        ]);

        $this->legalDeskService->attachDocument(
            $filing,
            $request->file('document_file'),
            $validated['document_type']
        );

        // If filing was queried, resubmitting moves it back to registry review
        if ($filing->isQueried()) {
            $this->legalDeskService->transitionStatus(
                filing: $filing,
                newStatus: ServiceFiling::STATUS_LODGED_AT_REGISTRY,
                actor: $user,
                remarks: 'Client uploaded replacement/queried document ('.$validated['document_type'].'). '.($validated['client_comment'] ?? '')
            );
        }

        return redirect()->route('member.filings.show', $filing->tracking_code)
            ->with('success', 'Document successfully uploaded and forwarded to the Legal Desk.');
    }

    /**
     * Download the verified official certificate.
     */
    public function downloadCertificate(Request $request, string $trackingCode): StreamedResponse|RedirectResponse
    {
        $user = $request->user();

        $filing = ServiceFiling::where('tracking_code', $trackingCode)
            ->where(function ($query) use ($user): void {
                $query->where('user_id', $user->id);
                if ($user->member) {
                    $query->orWhere('member_id', $user->member->id);
                }
            })
            ->firstOrFail();

        if (empty($filing->official_certificate_path) || ! Storage::disk('public')->exists($filing->official_certificate_path)) {
            return back()->with('error', 'The official certificate has not yet been uploaded or is currently being processed by the registry.');
        }

        $extension = pathinfo($filing->official_certificate_path, PATHINFO_EXTENSION) ?: 'pdf';
        $downloadName = Str::slug($filing->proposed_name_1)."-official-certificate.{$extension}";

        return Storage::disk('public')->download($filing->official_certificate_path, $downloadName);
    }
}
