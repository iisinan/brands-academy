@php
    $appUrl = rtrim(config('app.url') ?: url('/'), '/');
    $logoUrl = $appUrl . '/images/logo/bran-logo-128.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Evaluation - Brands Academy Nigeria Foundation</title>
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
                                            Faculty of Brand Practice &bull; Academic Mentorship Registry
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
                                Dear {{ $submission->application->applicant_name }},
                            </p>
                            
                            <p style="margin-top: 0; margin-bottom: 20px;">
                                Your mentor has completed the assessment of your practical project submission for <strong>{{ $submission->workshop->title ?? 'Brands Academy Programme' }}</strong>:
                            </p>

                            <!-- Submission Card -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid {{ $submission->status === 'approved' ? '#10b981' : '#f59e0b' }}; border-radius: 8px; margin: 24px 0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <div style="font-size: 11px; color: {{ $submission->status === 'approved' ? '#059669' : '#b45309' }}; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; margin-bottom: 6px;">
                                            Evaluation Status: {{ $submission->status === 'approved' ? 'Project Approved' : 'Revisions Requested' }}
                                        </div>
                                        <div style="font-size: 19px; font-weight: 800; color: #0f172a; letter-spacing: 0.3px;">
                                            {{ $submission->title }}
                                        </div>
                                        <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #475569; line-height: 1.6; border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 10px;">
                                            <tr>
                                                <td style="padding: 3px 0; width: 140px; font-weight: 600; color: #64748b;">Grade Awarded:</td>
                                                <td style="padding: 3px 0; font-weight: 700; color: #0f172a;">{{ $submission->grade ? ucfirst($submission->grade) : 'Pending' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Evaluated By:</td>
                                                <td style="padding: 3px 0; color: #334155;">{{ $submission->reviewed_by ?? 'Foundation Faculty Mentor' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Evaluation Date:</td>
                                                <td style="padding: 3px 0; color: #334155;">{{ $submission->reviewed_at?->format('F d, Y') ?? now()->format('F d, Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="color: #0f172a; font-size: 15px; font-weight: 700; margin-top: 28px; margin-bottom: 12px;">Mentor Feedback &amp; Commentary</h3>
                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px 20px; font-size: 13.5px; color: #334155; line-height: 1.65; margin: 16px 0;">
                                {!! nl2br(e($submission->mentor_feedback)) !!}
                            </div>

                            @if ($submission->status === 'approved')
                                <p style="font-size: 13.5px; color: #059669; font-weight: 600; margin-top: 18px; margin-bottom: 24px;">
                                    &check; Congratulations! Your deliverable satisfies our academic standards. The Office of the Registrar will issue your official verified Certificate of Achievement.
                                </p>
                            @else
                                <p style="font-size: 13.5px; color: #b45309; font-weight: 600; margin-top: 18px; margin-bottom: 24px;">
                                    &excl; Please review the feedback recommendations above and upload your revised deliverables via your member dashboard.
                                </p>
                            @endif

                            <!-- Primary CTA Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 32px auto 16px auto;">
                                <tr>
                                    <td align="center" style="border-radius: 8px; background-color: #d97706; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35);">
                                        <a href="{{ route('member.dashboard') }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 14.5px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px; letter-spacing: 0.5px; border: 1px solid #b45309;">
                                            Open Member Dashboard &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Institutional Signoff -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 24px;">
                                <tr>
                                    <td style="font-size: 13.5px; color: #475569; line-height: 1.6;">
                                        Warm regards,<br>
                                        <strong style="color: #0f172a;">Faculty &amp; Mentor Board</strong><br>
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
                                Academic Evaluation Notice &bull; Confidential &bull; &copy; {{ date('Y') }} Brands Academy Nigeria Foundation.
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
