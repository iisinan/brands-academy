<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Member;
use App\Services\BarcodeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Public credential verification interface.
     */
    public function index(Request $request, ?string $token = null): View
    {
        $searchQuery = trim($token ?? $request->query('q', ''));
        $certificate = null;
        $member = null;
        $barcode128 = null;
        $qrCode = null;
        $hasSearched = ! empty($searchQuery);

        if ($hasSearched) {
            // First check if matching certificate
            $certificate = Certificate::query()
                ->where('verification_token', $searchQuery)
                ->orWhere('certificate_number', $searchQuery)
                ->with(['workshop', 'member'])
                ->first();

            // If not found, check if matching member credential
            if (! $certificate) {
                $member = Member::query()
                    ->where('qr_code_token', $searchQuery)
                    ->orWhere('member_number', $searchQuery)
                    ->first();
            }

            if ($certificate) {
                $verifyUrl = route('verify.certificate', $certificate->verification_token);
                $barcode128 = BarcodeService::generateCode128Png($certificate->certificate_number, barWidth: 2, barHeight: 44, showText: true);
                $qrCode = BarcodeService::generateQrCodePng($verifyUrl, moduleSize: 5, quietZone: 3);
            } elseif ($member) {
                $verifyUrl = route('verify.certificate', $member->qr_code_token);
                $barcode128 = BarcodeService::generateCode128Png($member->member_number ?? 'MEMBER', barWidth: 2, barHeight: 44, showText: true);
                $qrCode = BarcodeService::generateQrCodePng($verifyUrl, moduleSize: 5, quietZone: 3);
            }
        }

        return view('verify', compact('searchQuery', 'certificate', 'member', 'hasSearched', 'barcode128', 'qrCode'));
    }
}
