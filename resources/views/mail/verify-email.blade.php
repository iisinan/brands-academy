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
    <title>Verify Your Email Address - Brands Academy Nigeria Foundation</title>
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
                                            Incorporated Trustee &bull; CAC/IT/No. 7344471 &bull; Membership &amp; Admissions
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
                                Dear {{ $user->name }},
                            </p>
                            
                            <p style="margin-top: 0; margin-bottom: 20px;">
                                Thank you for creating an account with <strong>Brands Academy Nigeria Foundation</strong>. To safeguard your profile, ensure verified correspondence, and comply with admissions protocol, please confirm your email address.
                            </p>

                            <!-- Access & Status Card -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #d97706; border-radius: 8px; margin: 24px 0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <div style="font-size: 11px; color: #b45309; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; margin-bottom: 8px;">
                                            Portal Access Requirement
                                        </div>
                                        <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; color: #475569; line-height: 1.6;">
                                            <tr>
                                                <td style="padding: 3px 0; width: 130px; font-weight: 600; color: #64748b;">Registered Email:</td>
                                                <td style="padding: 3px 0; font-weight: 700; color: #0f172a; font-family: monospace; font-size: 13.5px;">{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Verification:</td>
                                                <td style="padding: 3px 0;">
                                                    <span style="background-color: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Action Required
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Portal Access:</td>
                                                <td style="padding: 3px 0;">
                                                    <span style="background-color: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Locked Until Verified
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-top: 0; margin-bottom: 24px; font-size: 14.5px;">
                                Once verified, your account will be immediately unlocked, granting you direct access to your <strong>Member Dashboard</strong>, open cohort enrolments, faculty project assessments, and digital credentials.
                            </p>

                            <!-- Primary CTA Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 32px auto;">
                                <tr>
                                    <td align="center" style="border-radius: 8px; background-color: #d97706; box-shadow: 0 4px 14px rgba(217, 119, 6, 0.35);">
                                        <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 15px 36px; font-size: 15px; font-weight: 700; color: #ffffff; text-decoration: none; border-radius: 8px; letter-spacing: 0.5px; border: 1px solid #b45309; text-transform: none;">
                                            Verify Email &amp; Unlock Portal Access &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Expiry Box -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; margin: 24px 0;">
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 12.5px; color: #92400e; line-height: 1.5;">
                                        <strong>&#9201; Security Notice:</strong> This single-use verification link will expire in <strong>60 minutes</strong>. If you did not initiate this registration with Brands Academy Nigeria Foundation, no further action is required and your email address will remain unlinked.
                                    </td>
                                </tr>
                            </table>

                            <!-- Direct Link Fallback -->
                            <div style="font-size: 12px; color: #64748b; line-height: 1.5; margin-top: 24px; padding: 12px 16px; background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
                                <div style="font-weight: 600; color: #475569; margin-bottom: 4px;">Having trouble with the button?</div>
                                <div>Copy and paste this secure link directly into your browser:</div>
                                <div style="margin-top: 6px; word-break: break-all;">
                                    <a href="{{ $url }}" style="color: #d97706; text-decoration: underline;">{{ $url }}</a>
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
                                You are receiving this official correspondence because an account was registered with your email address.
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
