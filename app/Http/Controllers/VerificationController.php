<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Member;
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
        }

        return view('verify', compact('searchQuery', 'certificate', 'member', 'hasSearched'));
    }
}
