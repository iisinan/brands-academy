<?php

namespace App\Services;

use App\Models\FilingDocument;
use App\Models\FilingStatusLog;
use App\Models\ServiceFiling;
use App\Models\User;
use App\Notifications\EcosystemActivityNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class LegalDeskService
{
    /**
     * Calculate transparent pricing and membership discount for a filing.
     */
    public function calculatePricing(string $filingType, ?User $user = null): array
    {
        $pricing = ServiceFiling::getPricing($filingType);
        $isMember = false;

        if ($user) {
            $member = $user->member;
            if ($member && $member->isPaid()) {
                $isMember = true;
            }
        }

        $totalFee = $isMember ? (float) $pricing['member'] : (float) $pricing['regular'];
        $discount = $isMember ? ((float) $pricing['regular'] - (float) $pricing['member']) : 0.00;

        return [
            'type' => $filingType,
            'title' => $pricing['title'],
            'timeline' => $pricing['timeline'],
            'description' => $pricing['description'],
            'is_member' => $isMember,
            'regular_fee' => (float) $pricing['regular'],
            'final_fee' => $totalFee,
            'member_discount' => $discount,
        ];
    }

    /**
     * Initialize and store a client service filing record.
     */
    public function createFiling(array $data, ?User $user = null): ServiceFiling
    {
        $filingType = $data['filing_type'] ?? ServiceFiling::TYPE_CAC_BUSINESS_NAME;
        $cost = $this->calculatePricing($filingType, $user);

        $filing = ServiceFiling::create([
            'user_id' => $user?->id,
            'member_id' => $user?->member?->id,
            'filing_type' => $filingType,
            'proposed_name_1' => $data['proposed_name_1'],
            'proposed_name_2' => $data['proposed_name_2'] ?? null,
            'proposed_name_3' => $data['proposed_name_3'] ?? null,
            'business_nature' => $data['business_nature'] ?? null,
            'industry_category' => $data['industry_category'] ?? null,
            'business_address' => $data['business_address'] ?? null,
            'headquarters_state' => $data['headquarters_state'] ?? null,
            'client_first_name' => $data['client_first_name'],
            'client_last_name' => $data['client_last_name'],
            'client_email' => $data['client_email'],
            'client_phone' => $data['client_phone'],
            'client_nin' => $data['client_nin'] ?? null,
            'filing_data' => $data['filing_data'] ?? [],
            'status' => ServiceFiling::STATUS_PAYMENT_PENDING,
            'total_fee' => $cost['final_fee'],
            'member_discount' => $cost['member_discount'],
            'fee_paid' => 0.00,
        ]);

        FilingStatusLog::create([
            'service_filing_id' => $filing->id,
            'from_status' => 'initialized',
            'to_status' => ServiceFiling::STATUS_PAYMENT_PENDING,
            'changed_by_user_id' => $user?->id,
            'remarks' => 'Filing created and awaiting statutory fee payment.',
        ]);

        return $filing;
    }

    /**
     * Attach an uploaded verification document to a filing.
     */
    public function attachDocument(ServiceFiling $filing, UploadedFile $file, string $documentType): FilingDocument
    {
        $path = $file->store("filings/{$filing->tracking_code}", 'public');

        return FilingDocument::create([
            'service_filing_id' => $filing->id,
            'document_type' => $documentType,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
            'is_verified' => false,
        ]);
    }

    /**
     * Mark filing payment as verified and lodge filing with legal desk.
     */
    public function markAsPaid(ServiceFiling $filing, string $gateway, string $reference): ServiceFiling
    {
        $oldStatus = $filing->status;
        $filing->update([
            'status' => ServiceFiling::STATUS_SUBMITTED,
            'fee_paid' => $filing->total_fee,
            'payment_gateway' => $gateway,
            'payment_reference' => $reference,
            'submitted_at' => Carbon::now(),
        ]);

        FilingStatusLog::create([
            'service_filing_id' => $filing->id,
            'from_status' => $oldStatus,
            'to_status' => ServiceFiling::STATUS_SUBMITTED,
            'remarks' => 'Payment of ₦'.number_format($filing->total_fee, 2)." verified via {$gateway} (Ref: {$reference}). Forwarded to Legal Operations Desk.",
        ]);

        return $filing;
    }

    /**
     * Transition filing status with legal team remarks and audit log.
     */
    public function transitionStatus(
        ServiceFiling $filing,
        string $newStatus,
        ?User $actor = null,
        ?string $remarks = null,
        ?string $govtNumber = null,
        ?string $queryMsg = null
    ): ServiceFiling {
        $oldStatus = $filing->status;

        $updates = [
            'status' => $newStatus,
        ];

        if ($newStatus === ServiceFiling::STATUS_QUERIED) {
            $updates['client_query_message'] = $queryMsg;
        } elseif ($newStatus === ServiceFiling::STATUS_APPROVED || $newStatus === ServiceFiling::STATUS_DELIVERED) {
            $updates['approved_at'] = $filing->approved_at ?: Carbon::now();
            $updates['client_query_message'] = null; // Clear query once resolved/approved
        }

        if ($govtNumber) {
            $updates['government_filing_number'] = $govtNumber;
        }

        if ($remarks) {
            $existingNotes = $filing->admin_notes ? $filing->admin_notes."\n" : '';
            $updates['admin_notes'] = $existingNotes.'['.Carbon::now()->toDateTimeString().' - '.($actor ? $actor->name : 'System').']: '.$remarks;
        }

        $filing->update($updates);

        FilingStatusLog::create([
            'service_filing_id' => $filing->id,
            'from_status' => $oldStatus,
            'to_status' => $newStatus,
            'changed_by_user_id' => $actor?->id,
            'remarks' => $remarks ?: 'Status updated to '.ucfirst(str_replace('_', ' ', $newStatus)),
        ]);

        if ($filing->user) {
            $statusLabel = $filing->fresh()->status_label;
            $msg = $remarks ?: "Your filing {$filing->tracking_code} has transitioned to {$statusLabel}.";
            if ($newStatus === ServiceFiling::STATUS_QUERIED && $queryMsg) {
                $msg = "Examiner query on {$filing->tracking_code}: {$queryMsg}";
            }

            $filing->user->notify(new EcosystemActivityNotification(
                title: "Filing Status: {$statusLabel}",
                message: $msg,
                actionUrl: route('member.filings.show', $filing->tracking_code),
                category: 'filing',
                badgeText: $filing->tracking_code
            ));
        }

        return $filing;
    }

    /**
     * Upload approved official government certificate.
     */
    public function uploadOfficialCertificate(ServiceFiling $filing, UploadedFile $file, ?User $actor = null, ?string $govtNumber = null): ServiceFiling
    {
        $path = $file->store("certificates/official_cac/{$filing->tracking_code}", 'public');

        $filing->update([
            'official_certificate_path' => $path,
            'government_filing_number' => $govtNumber ?: $filing->government_filing_number,
        ]);

        return $this->transitionStatus(
            filing: $filing,
            newStatus: ServiceFiling::STATUS_APPROVED,
            actor: $actor,
            remarks: 'Official government certificate uploaded. Government Filing / Registration No: '.($govtNumber ?: $filing->government_filing_number),
            govtNumber: $govtNumber
        );
    }
}
