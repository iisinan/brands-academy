<?php

namespace App\Http\Controllers;

use App\Mail\CertificateIssuedMail;
use App\Models\Certificate;
use App\Services\BarcodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CertificateController extends Controller
{
    /**
     * Download high-resolution PDF certificate.
     */
    public function download(string $token): Response
    {
        $certificate = Certificate::where('verification_token', $token)
            ->orWhere('certificate_number', $token)
            ->firstOrFail();

        $pdf = $this->renderPdf($certificate);

        return $pdf->download("Brands_Academy_Certificate_{$certificate->certificate_number}.pdf");
    }

    /**
     * Stream PDF in browser for preview.
     */
    public function preview(string $token): Response
    {
        $certificate = Certificate::where('verification_token', $token)
            ->orWhere('certificate_number', $token)
            ->firstOrFail();

        $pdf = $this->renderPdf($certificate);

        return $pdf->stream("Brands_Academy_Certificate_{$certificate->certificate_number}.pdf");
    }

    /**
     * Re-send or manually dispatch the certificate email.
     */
    public function email(string $token): RedirectResponse
    {
        $certificate = Certificate::where('verification_token', $token)
            ->orWhere('certificate_number', $token)
            ->firstOrFail();

        $success = $this->sendCertificateEmail($certificate);

        if ($success) {
            return back()->with('success', "Certificate #{$certificate->certificate_number} has been emailed to {$certificate->recipient_email}.");
        }

        return back()->with('error', "Could not deliver email to {$certificate->recipient_email}: ".($certificate->email_error ?? 'Check mail configuration.'));
    }

    /**
     * Internal helper to render the DomPDF instance.
     */
    public function renderPdf(Certificate $certificate): \Barryvdh\DomPDF\PDF
    {
        $verifyUrl = route('verify.certificate', $certificate->verification_token);

        // Generate real, mathematically valid QR code and Code-128 linear barcode PNGs
        $qrCode = BarcodeService::generateQrCodePng($verifyUrl, moduleSize: 5, quietZone: 3);
        $barcode128 = BarcodeService::generateCode128Png($certificate->certificate_number, barWidth: 2, barHeight: 38, showText: true);

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'qrCode' => $qrCode,
            'barcode128' => $barcode128,
            'verifyUrl' => $verifyUrl,
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);

        return $pdf;
    }

    /**
     * Helper to render PDF and dispatch via Laravel Mail.
     */
    public function sendCertificateEmail(Certificate $certificate): bool
    {
        try {
            $pdf = $this->renderPdf($certificate);
            $pdfContent = $pdf->output();

            Mail::to($certificate->recipient_email)->send(new CertificateIssuedMail($certificate, $pdfContent));

            $certificate->update([
                'email_status' => 'sent',
                'email_sent_at' => now(),
                'email_error' => null,
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error("Certificate email dispatch failed for #{$certificate->certificate_number}: ".$e->getMessage());

            $certificate->update([
                'email_status' => 'failed',
                'email_error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
