<?php

namespace App\Http\Controllers;

use App\Models\ServiceFiling;
use App\Services\LegalDeskService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminLegalDeskController extends Controller
{
    public function __construct(
        protected LegalDeskService $legalDeskService
    ) {}

    /**
     * Admin Legal Operations Desk Overview.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $type = $request->query('type');
        $search = $request->query('q');

        $query = ServiceFiling::query()
            ->with(['user', 'member'])
            ->withCount('documents');

        if (! empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (! empty($type) && $type !== 'all') {
            $query->where('filing_type', $type);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search): void {
                $q->where('tracking_code', 'like', "%{$search}%")
                    ->orWhere('proposed_name_1', 'like', "%{$search}%")
                    ->orWhere('client_first_name', 'like', "%{$search}%")
                    ->orWhere('client_last_name', 'like', "%{$search}%")
                    ->orWhere('client_email', 'like', "%{$search}%")
                    ->orWhere('government_filing_number', 'like', "%{$search}%");
            });
        }

        $filings = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'total' => ServiceFiling::count(),
            'pending' => ServiceFiling::where('status', ServiceFiling::STATUS_PAYMENT_PENDING)->count(),
            'in_progress' => ServiceFiling::whereIn('status', [
                ServiceFiling::STATUS_SUBMITTED,
                ServiceFiling::STATUS_SEARCH_IN_PROGRESS,
                ServiceFiling::STATUS_LODGED_AT_REGISTRY,
            ])->count(),
            'queried' => ServiceFiling::where('status', ServiceFiling::STATUS_QUERIED)->count(),
            'approved' => ServiceFiling::whereIn('status', [
                ServiceFiling::STATUS_APPROVED,
                ServiceFiling::STATUS_DELIVERED,
            ])->count(),
        ];

        return view('admin.filings.index', [
            'filings' => $filings,
            'stats' => $stats,
            'selectedStatus' => $status,
            'selectedType' => $type,
            'search' => $search,
        ]);
    }

    /**
     * View detailed legal case file.
     */
    public function show(int $id): View
    {
        $filing = ServiceFiling::with(['user', 'member', 'documents', 'statusLogs.changedByUser'])
            ->findOrFail($id);

        return view('admin.filings.show', [
            'filing' => $filing,
        ]);
    }

    /**
     * Transition legal case status with notes or queries.
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $filing = ServiceFiling::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:payment_pending,submitted,search_in_progress,lodged_at_registry,queried,approved,delivered,rejected'],
            'remarks' => ['nullable', 'string', 'max:2000'],
            'government_filing_number' => ['nullable', 'string', 'max:100'],
            'client_query_message' => ['nullable', 'string', 'max:2000'],
        ]);

        $this->legalDeskService->transitionStatus(
            filing: $filing,
            newStatus: $validated['status'],
            actor: $request->user(),
            remarks: $validated['remarks'] ?? null,
            govtNumber: $validated['government_filing_number'] ?? null,
            queryMsg: $validated['client_query_message'] ?? null
        );

        return redirect()->route('admin.filings.show', $filing->id)
            ->with('success', 'Case status successfully updated to '.$filing->fresh()->status_label);
    }

    /**
     * Upload approved official certificate from CAC / Trademark Registry.
     */
    public function uploadCertificate(Request $request, int $id): RedirectResponse
    {
        $filing = ServiceFiling::findOrFail($id);

        $validated = $request->validate([
            'official_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:20480'],
            'government_filing_number' => ['required', 'string', 'max:100'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->legalDeskService->uploadOfficialCertificate(
            filing: $filing,
            file: $request->file('official_certificate'),
            actor: $request->user(),
            govtNumber: $validated['government_filing_number']
        );

        return redirect()->route('admin.filings.show', $filing->id)
            ->with('success', 'Official registration certificate uploaded and case marked as Approved & Certified!');
    }

    /**
     * Export all filings to CSV.
     */
    public function exportCsv(): StreamedResponse
    {
        $filings = ServiceFiling::orderBy('id', 'desc')->get();
        $filename = 'legal-filings-export-'.date('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($filings): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Tracking Code',
                'Service Type',
                'Proposed Name 1',
                'Client Name',
                'Client Email',
                'Client Phone',
                'State',
                'Status',
                'Total Fee (NGN)',
                'Govt Filing Number',
                'Created At',
            ]);

            foreach ($filings as $f) {
                fputcsv($handle, [
                    $f->tracking_code,
                    $f->type_title,
                    $f->proposed_name_1,
                    "{$f->client_first_name} {$f->client_last_name}",
                    $f->client_email,
                    $f->client_phone,
                    $f->headquarters_state,
                    $f->status_label,
                    $f->total_fee,
                    $f->government_filing_number ?: 'Pending',
                    $f->created_at->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
