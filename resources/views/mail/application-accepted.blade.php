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
    <title>Offer of Admission - Brands Academy Nigeria Foundation</title>
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
                                            Incorporated Trustee &bull; RC / IT No. 7344471 &bull; Office of Admissions
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
                                Dear {{ $application->applicant_name }},
                            </p>
                            
                            <p style="margin-top: 0; margin-bottom: 20px;">
                                We are delighted to inform you that following evaluation by our faculty committee, you have officially received an <strong>Offer of Admission</strong> into Brands Academy Nigeria Foundation:
                            </p>

                            <!-- Offer Details Card -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #10b981; border-radius: 8px; margin: 24px 0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <div style="font-size: 11px; color: #059669; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; margin-bottom: 6px;">
                                            Admission Offer Confirmed
                                        </div>
                                        <div style="font-size: 19px; font-weight: 800; color: #0f172a; letter-spacing: 0.3px;">
                                            {{ $application->workshop->title }}
                                        </div>
                                        <div style="font-size: 13.5px; color: #b45309; font-weight: 700; margin-top: 3px; margin-bottom: 14px;">
                                            {{ $application->workshop->track_label }}
                                        </div>
                                        <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #475569; line-height: 1.6; border-top: 1px solid #e2e8f0; padding-top: 10px;">
                                            <tr>
                                                <td style="padding: 3px 0; width: 140px; font-weight: 600; color: #64748b;">Delivery Mode:</td>
                                                <td style="padding: 3px 0; font-weight: 600; color: #0f172a;">{{ ucfirst($application->workshop->delivery_mode) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Commencement Date:</td>
                                                <td style="padding: 3px 0; font-weight: 600; color: #0f172a;">{{ $application->workshop->starts_at->format('F d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Funding / Tuition:</td>
                                                <td style="padding: 3px 0; color: #334155;">{{ $application->scholarship_requested ? 'Foundation Educational Subsidy / Scholarship Approved' : ($application->workshop->fee_type == 'free' ? '100% Free Track' : 'Standard Enrolment') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #0f172a; font-size: 15px; font-weight: 700; margin-top: 28px; margin-bottom: 12px;">Next Steps: Orientation &amp; Mentor Pairing (Step 5)</h3>
                            <p style="font-size: 13.5px; color: #475569; line-height: 1.65; margin-top: 0; margin-bottom: 24px;">
                                Our curriculum pairs each learner with practical guided support from industry practitioners. You will receive an invitation to the virtual orientation session shortly before training begins.
                            </p>

                            <!-- Primary CTA Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 32px auto 16px auto;">
                                <tr>
                                    <td align="center" style="border-radius: 8px; background-color: #d97706; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35);">
                                        <a href="{{ route('workshops.show', $application->workshop->slug) }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 14.5px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px; letter-spacing: 0.5px; border: 1px solid #b45309;">
                                            View Programme Details &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Institutional Signoff -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 24px;">
                                <tr>
                                    <td style="font-size: 13.5px; color: #475569; line-height: 1.6;">
                                        Congratulations once again on your selection,<br>
                                        <strong style="color: #0f172a;">Admissions &amp; Credentials Committee</strong><br>
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
                                Brands Academy Nigeria Foundation (Incorporated Trustee &bull; RC / IT No. 7344471)
                            </p>
                            <p style="margin: 0 0 8px 0;">
                                No. 27C, Ilorin Crescent, Ali-Akilu West, Marafa, Kaduna State, Nigeria.
                            </p>
                            <p style="margin: 0; color: #cbd5e1; font-size: 10.5px;">
                                Admissions Correspondence &bull; Confidential &bull; &copy; {{ date('Y') }} Brands Academy Nigeria Foundation.
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
