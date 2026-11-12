@php
    $appUrl = rtrim(config('app.url') ?: url('/'), '/');
    $logoUrl = $appUrl . '/images/logo/bran-logo-128.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Certificate Samples — Brands Academy Nigeria Foundation</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; color: #1e293b; padding: 24px 12px; margin: 0; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 10px 0 30px 0;">
                
                <!-- Main Container -->
                <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 640px; background-color: #ffffff; border-radius: 14px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);">
                    
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
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 800; letter-spacing: 2.5px; text-transform: uppercase; line-height: 1.2;">
                                Brands Academy
                            </h1>
                            <p style="color: #f59e0b; margin: 5px 0 0 0; font-size: 12px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;">
                                Nigeria Foundation
                            </p>
                            
                            <!-- Division Badge -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 14px auto 0 auto;">
                                <tr>
                                    <td align="center" style="background-color: rgba(217, 119, 6, 0.14); border: 1px solid rgba(217, 119, 6, 0.4); border-radius: 20px; padding: 4px 14px;">
                                        <span style="color: #cbd5e1; font-size: 10px; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase;">
                                            Incorporated Trustee &bull; CAC/IT/No. 7344471 &bull; Executive Credential Registry
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
                                Dear {{ $recipientName }},
                            </p>
                            
                            <p style="margin-top: 0; margin-bottom: 22px;">
                                As requested, please find attached the official high-resolution PDF samples for the <strong>Brands Academy Nigeria Foundation</strong> credential suites. Both certificates feature mathematically accurate, verified scannable barcodes and calligraphic signatures.
                            </p>

                            <!-- Sample 1: Certificate of Achievement -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #d97706; border-radius: 10px; margin: 18px 0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px 22px;">
                                        <div style="font-size: 10.5px; color: #b45309; text-transform: uppercase; font-weight: 800; letter-spacing: 1.2px; margin-bottom: 6px;">
                                            Sample Credential #1 &bull; Workshop Graduation
                                        </div>
                                        <div style="font-size: 18px; font-weight: 800; color: #0f172a;">
                                            Certificate of Achievement
                                        </div>
                                        <div style="font-size: 13px; color: #64748b; margin-top: 2px; margin-bottom: 14px;">
                                            Certified Professional Track: <strong>Tier 1: Certified Brand Associate (CBA)</strong>
                                        </div>

                                        <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 12.5px; color: #475569; line-height: 1.6; border-top: 1px solid #e2e8f0; padding-top: 10px;">
                                            <tr>
                                                <td style="padding: 3px 0; width: 140px; font-weight: 600; color: #64748b;">Credential Number:</td>
                                                <td style="padding: 3px 0; font-weight: 700; color: #0f172a; font-family: monospace;">{{ $workshopCertificate->certificate_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Sample Recipient:</td>
                                                <td style="padding: 3px 0; font-weight: 600; color: #0f172a;">{{ $workshopCertificate->recipient_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Security Barcodes:</td>
                                                <td style="padding: 3px 0;">
                                                    <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                                        Code-128 Linear Barcode + 2D QR Code (Verified Scannable)
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0 2px 0; font-weight: 600; color: #64748b;">Online Verification:</td>
                                                <td style="padding: 6px 0 2px 0;">
                                                    <a href="{{ $workshopVerifyUrl }}" target="_blank" style="color: #d97706; font-weight: 700; text-decoration: underline; font-size: 12px;">
                                                        Verify Achievement Credential &rarr;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Sample 2: Certificate of Membership -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #10b981; border-radius: 10px; margin: 18px 0; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px 22px;">
                                        <div style="font-size: 10.5px; color: #059669; text-transform: uppercase; font-weight: 800; letter-spacing: 1.2px; margin-bottom: 6px;">
                                            Sample Credential #2 &bull; Institutional Induction
                                        </div>
                                        <div style="font-size: 18px; font-weight: 800; color: #0f172a;">
                                            Certificate of Membership
                                        </div>
                                        <div style="font-size: 13px; color: #64748b; margin-top: 2px; margin-bottom: 14px;">
                                            Institutional Category: <strong>{{ $membership->category_label }}</strong>
                                        </div>

                                        <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 12.5px; color: #475569; line-height: 1.6; border-top: 1px solid #e2e8f0; padding-top: 10px;">
                                            <tr>
                                                <td style="padding: 3px 0; width: 140px; font-weight: 600; color: #64748b;">Member ID Number:</td>
                                                <td style="padding: 3px 0; font-weight: 700; color: #0f172a; font-family: monospace;">{{ $membership->member_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Sample Inductee:</td>
                                                <td style="padding: 3px 0; font-weight: 600; color: #0f172a;">{{ $membership->full_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 3px 0; font-weight: 600; color: #64748b;">Security Barcodes:</td>
                                                <td style="padding: 3px 0;">
                                                    <span style="background-color: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                                        Code-128 Linear Barcode + 2D QR Code (Verified Scannable)
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0 2px 0; font-weight: 600; color: #64748b;">Online Verification:</td>
                                                <td style="padding: 6px 0 2px 0;">
                                                    <a href="{{ $membershipVerifyUrl }}" target="_blank" style="color: #059669; font-weight: 700; text-decoration: underline; font-size: 12px;">
                                                        Verify Membership Induction &rarr;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Features Callout -->
                            <div style="background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 16px 20px; font-size: 13px; color: #334155; margin: 26px 0;">
                                <div style="font-weight: 700; color: #0f172a; margin-bottom: 6px; font-size: 13.5px;">
                                    Key Security &amp; Design Architecture:
                                </div>
                                <ul style="margin: 0; padding-left: 20px; line-height: 1.65; color: #475569;">
                                    <li><strong>1D Code-128 Linear Barcode:</strong> ISO/IEC 15417 compliant with quiet zones, start/stop codes, and modulo 103 checksums, readable by standard handheld optical barcode scanners.</li>
                                    <li><strong>2D High-Density QR Code:</strong> Scannable directly with smartphone cameras, resolving directly to the institutional registry verification page.</li>
                                    <li><strong>Authentic Signatures:</strong> Board of Trustees Chairman (Prof. Samaila Mande) and Registrar / Secretary to the Board (Titus Eveshoyan).</li>
                                    <li><strong>Official 3D Medallion Seal:</strong> Gold-rimmed institutional seal rendered at native resolution.</li>
                                    <li><strong>Sovereign Double Ornamental Framing:</strong> Precision landscape A4 framing engineered for 100% boundary symmetry.</li>
                                </ul>
                            </div>

                            <p style="font-size: 13.5px; color: #64748b; margin-bottom: 0;">
                                Both complete PDF files are attached to this message:
                                <br>
                                &bull; <strong style="color: #0f172a;">Brands_Academy_Certificate_of_Achievement_{{ $workshopCertificate->certificate_number }}.pdf</strong>
                                <br>
                                &bull; <strong style="color: #0f172a;">Brands_Academy_Membership_Certificate_{{ $membership->member_number }}.pdf</strong>
                            </p>

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
                                Official Credential Sample Correspondence &bull; Confidential &bull; &copy; {{ date('Y') }} Brands Academy Nigeria Foundation.
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
