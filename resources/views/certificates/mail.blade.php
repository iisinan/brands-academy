@php
    $appUrl = config('app.url');
    if (empty($appUrl) || str_contains($appUrl, 'localhost') || str_contains($appUrl, '127.0.0.1')) {
        $appUrl = 'https://ecoenergy-ltd.com';
    }
    $logoUrl = rtrim($appUrl, '/') . '/images/logo/bran-logo-128.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Brands Academy Certificate of Achievement</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; color: #1e293b; padding: 24px 12px; margin: 0; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 10px 0 30px 0;">
                
                <!-- Main Container -->
                <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 14px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);">
                    
                    <!-- Institutional Header -->
                    <tr>
                        <td align="center" style="background-color: #0f172a; padding: 36px 24px 28px 24px; border-bottom: 3px solid #d97706; text-align: center;">
                            
                            <!-- Circular Crest Badge -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 0 auto 16px auto;">
                                <tr>
                                    <td align="center" valign="middle" style="width: 72px; height: 72px; background-color: #1e293b; border: 2px solid #d97706; border-radius: 50%; padding: 4px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.35);">
                                        <img src="{{ $logoUrl }}" width="64" height="64" alt="Brands Academy" border="0" style="display: block; width: 64px; height: 64px; border-radius: 50%; object-fit: contain; margin: 0 auto;">
                                    </td>
                                </tr>
                            </table>

                            <!-- Typography -->
                            <h1 style="color: #ffffff; margin: 0; font-size: 21px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; line-height: 1.2;">
                                Brands Academy
                            </h1>
                            <p style="color: #f59e0b; margin: 5px 0 0 0; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;">
                                Nigeria Foundation
                            </p>
                            
                            <!-- Division Badge -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 14px auto 0 auto;">
                                <tr>
                                    <td align="center" style="background-color: rgba(217, 119, 6, 0.14); border: 1px solid rgba(217, 119, 6, 0.4); border-radius: 20px; padding: 4px 14px;">
                                        <span style="color: #cbd5e1; font-size: 10.5px; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase;">
                                            Incorporated Trustee &bull; CAC/IT/No. 7344471 &bull; Certification Registry
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px 28px 32px; font-size: 15px; line-height: 1.65; color: #334155;">
                            
                            <p style="font-size: 18px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 16px;">
                                Dear {{ $certificate->recipient_name }},
                            </p>
                            
                            <p style="margin-top: 0; margin-bottom: 20px;">
                                Congratulations! On behalf of the Board of Trustees and faculty of <strong>Brands Academy Nigeria Foundation</strong>, we are proud to confirm that you have met all academic standards and successfully graduated from:
                            </p>

                            <!-- Certificate Details Card -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #d97706; border-radius: 8px; margin: 24px 0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <div style="font-size: 11px; color: #b45309; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; margin-bottom: 6px;">
                                            Accredited Programme Completed
                                        </div>
                                        <div style="font-size: 19px; font-weight: 800; color: #0f172a; letter-spacing: 0.3px;">
                                            {{ $certificate->course_title }}
                                        </div>
                                        <div style="font-size: 13.5px; color: #b45309; font-weight: 700; margin-top: 3px; margin-bottom: 14px;">
                                            {{ $certificate->track_tier }}
                                        </div>
                                        <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #475569; line-height: 1.6; border-top: 1px solid #e2e8f0; padding-top: 10px;">
                                            <tr>
                                                <td style="padding: 3px 0; width: 140px; font-weight: 600; color: #64748b;">Certificate No:</td>
                                                <td style="padding: 3px 0; font-weight: 700; color: #0f172a; font-family: monospace;">{{ $certificate->certificate_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Credential Status:</td>
                                                <td style="padding: 3px 0;">
                                                    <span style="background-color: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Verified &bull; Officially Sealed
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 14.5px; color: #334155; margin-bottom: 24px;">
                                Your official, tamper-proof <strong>Certificate of Achievement</strong> is attached to this email as a high-resolution PDF document. You may download, print, or share it on your LinkedIn profile and professional credentials.
                            </p>

                            <!-- Primary CTA Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 32px auto 16px auto;">
                                <tr>
                                    <td align="center" style="border-radius: 8px; background-color: #d97706; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35);">
                                        <a href="{{ route('verify.certificate', $certificate->verification_token) }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 14.5px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px; letter-spacing: 0.5px; border: 1px solid #b45309;">
                                            Verify Certificate Online &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 16px; font-size: 12px; color: #64748b; margin-top: 24px; word-break: break-all;">
                                Employers and academic institutions can verify this credential at any time by scanning the QR code on your certificate or visiting:
                                <div style="margin-top: 4px;">
                                    <a href="{{ route('verify.certificate', $certificate->verification_token) }}" style="color: #d97706; text-decoration: underline;">
                                        {{ route('verify.certificate', $certificate->verification_token) }}
                                    </a>
                                </div>
                            </div>

                            <!-- Institutional Signoff -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 24px;">
                                <tr>
                                    <td style="font-size: 13.5px; color: #475569; line-height: 1.6;">
                                        Warm regards,<br>
                                        <strong style="color: #0f172a;">Office of the Registrar &amp; Board Secretariat</strong><br>
                                        Brands Academy Nigeria Foundation<br>
                                        Kaduna, Nigeria
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f8fafc; padding: 24px 20px; font-size: 11px; color: #94a3b8; line-height: 1.6; border-top: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0 0 6px 0; font-weight: 600; color: #64748b;">
                                Brands Academy Nigeria Foundation (Incorporated Trustee &bull; CAC/IT/No. 7344471)
                            </p>
                            <p style="margin: 0 0 8px 0;">
                                No. 27C, Ilorin Crescent, Ali-Akilu West, Marafa, Kaduna State, Nigeria.
                            </p>
                            <p style="margin: 0; color: #cbd5e1; font-size: 10.5px;">
                                Official Credential Correspondence &bull; Confidential &bull; &copy; {{ date('Y') }} Brands Academy Nigeria Foundation.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- End Main Container -->

            </td>
        </tr>
    </table>
</body>
</html>
