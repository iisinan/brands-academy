<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Membership - Brands Academy Nigeria Foundation</title>
    <style>
        @page {
            size: 841.89pt 595.28pt;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 841.89pt;
            height: 595.28pt;
            background-color: #ffffff;
            color: #0f172a;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            position: relative;
        }

        /* Sovereign Triple Ornamental Frame */
        .outer-border {
            position: absolute;
            top: 16pt;
            left: 16pt;
            width: 809.89pt;
            height: 563.28pt;
            border: 3.5pt solid #0f172a;
        }

        .mid-border {
            position: absolute;
            top: 4pt;
            left: 4pt;
            width: 799.89pt;
            height: 553.28pt;
            border: 1.5pt solid #d97706;
        }

        .inner-border {
            position: absolute;
            top: 3.5pt;
            left: 3.5pt;
            width: 790.89pt;
            height: 544.28pt;
            border: 0.6pt solid #cbd5e1;
        }

        /* Sovereign Corner Accents */
        .corner {
            position: absolute;
            width: 18pt;
            height: 18pt;
            border-color: #d97706;
            border-style: solid;
        }
        .corner-tl { top: 3pt; left: 3pt; border-width: 2.5pt 0 0 2.5pt; }
        .corner-tr { top: 3pt; right: 3pt; border-width: 2.5pt 2.5pt 0 0; }
        .corner-bl { bottom: 3pt; left: 3pt; border-width: 0 0 2.5pt 2.5pt; }
        .corner-br { bottom: 3pt; right: 3pt; border-width: 0 2.5pt 2.5pt 0; }

        /* Subtle Center Watermark */
        .bg-watermark {
            position: absolute;
            top: 130pt;
            left: 255pt;
            width: 280pt;
            height: 280pt;
            opacity: 0.95;
            z-index: 1;
        }

        .content-box {
            position: relative;
            z-index: 2;
            padding: 18pt 36pt 12pt 36pt;
            text-align: center;
        }

        .header-logo {
            width: 58pt;
            height: 58pt;
            display: block;
            margin: 0 auto;
        }

        .institution-title {
            font-size: 21pt;
            font-weight: 800;
            letter-spacing: 4.5px;
            color: #0f172a;
            text-transform: uppercase;
            line-height: 1.1;
            margin-top: 2pt;
        }

        .institution-subtitle {
            font-size: 9.5pt;
            letter-spacing: 3px;
            color: #b45309;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 3pt;
            margin-bottom: 2pt;
        }

        .legal-subtext {
            font-size: 7.2pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            margin-bottom: 8pt;
        }

        .cert-type {
            font-family: 'Times-Roman', 'Times New Roman', serif;
            font-size: 15pt;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #1e293b;
            font-weight: bold;
            margin-bottom: 4pt;
        }

        .cert-presentation {
            font-size: 9.5pt;
            color: #64748b;
            font-style: italic;
            margin-bottom: 8pt;
        }

        .recipient-name {
            font-family: 'Times-Roman', 'Times New Roman', serif;
            font-size: 34pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 2.5pt solid #f59e0b;
            display: inline-block;
            padding: 0 46pt 5pt 46pt;
            margin-bottom: 11pt;
            letter-spacing: 0.8px;
        }

        .cert-body {
            font-size: 10pt;
            line-height: 1.55;
            color: #334155;
            max-width: 630pt;
            margin: 0 auto 9pt auto;
        }

        .category-badge-pill {
            display: inline-block;
            padding: 5pt 28pt;
            border: 1.4pt solid #d97706;
            background-color: #fffbeb;
            color: #92400e;
            border-radius: 18pt;
            font-size: 13pt;
            font-weight: 800;
            letter-spacing: 2.2px;
            text-transform: uppercase;
            margin-bottom: 6pt;
        }

        .affiliation-text {
            font-size: 9pt;
            color: #64748b;
            font-style: italic;
            margin-bottom: 11pt;
        }

        .conferral-proclamation {
            font-size: 9pt;
            color: #475569;
            font-style: italic;
            max-width: 630pt;
            margin: 0 auto 13pt auto;
            line-height: 1.55;
        }

        .ornamental-filigree {
            width: 180pt;
            height: 1.5pt;
            background-color: #d97706;
            margin: 0 auto 14pt auto;
        }

        .footer-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 2pt;
        }

        .footer-table td {
            vertical-align: bottom;
            text-align: center;
        }

        .sig-container {
            height: 52pt;
            vertical-align: bottom;
            text-align: center;
        }

        .sig-img {
            height: 48pt;
            max-width: 165pt;
            display: block;
            margin: 0 auto -4pt auto;
        }

        .sig-line {
            width: 165pt;
            border-top: 1.2pt solid #334155;
            margin: 0 auto 3pt auto;
        }

        .sig-name {
            font-size: 9.5pt;
            font-weight: 700;
            color: #0f172a;
        }

        .sig-title {
            font-size: 7.8pt;
            color: #64748b;
        }

        .security-badge-panel {
            background-color: #f8fafc;
            border: 0.8pt solid #cbd5e1;
            border-radius: 6pt;
            padding: 4pt 8pt 3pt 8pt;
            display: inline-block;
        }

        .barcode-img {
            height: 32pt;
            width: auto;
            display: block;
            margin: 0 auto 2pt auto;
        }

        .qr-img {
            width: 48pt;
            height: 48pt;
            display: inline-block;
            border: 1pt solid #cbd5e1;
            padding: 2pt;
            background: #ffffff;
        }

        .meta-table {
            width: 100%;
            margin-top: 12pt;
            font-size: 7pt;
            color: #64748b;
            border-top: 0.8pt solid #e2e8f0;
            padding-top: 4pt;
            border-collapse: separate;
            border-spacing: 0;
        }

        .specimen-watermark {
            position: absolute;
            top: 230pt;
            left: 200pt;
            width: 390pt;
            text-align: center;
            font-size: 58pt;
            font-weight: 900;
            color: rgba(220, 38, 38, 0.14);
            letter-spacing: 14pt;
            text-transform: uppercase;
            border: 4pt dashed rgba(220, 38, 38, 0.18);
            padding: 8pt 20pt;
            border-radius: 10pt;
            transform: rotate(-18deg);
            z-index: 99;
        }
    </style>
</head>
<body>

    <div class="outer-border">
        <div class="mid-border">
            <div class="inner-border">
                @if(!empty($isSpecimen) || (isset($member) && (str_contains(strtolower($member->full_name), 'chidi okafor') || str_contains(strtolower($member->member_number), 'sample') || str_contains(strtolower($member->member_number), 'specimen'))))
                    <div class="specimen-watermark">SPECIMEN</div>
                @endif
                <!-- Sovereign Corner Accents -->
                <div class="corner corner-tl"></div>
                <div class="corner corner-tr"></div>
                <div class="corner corner-bl"></div>
                <div class="corner corner-br"></div>

                <!-- Subtle Background Watermark -->
                @if(file_exists(public_path('images/logo/bran-watermark.png')))
                    <img src="{{ public_path('images/logo/bran-watermark.png') }}" class="bg-watermark" alt="Watermark">
                @endif

                <div class="content-box">
                    <!-- Flanked 3D Crest Header -->
                    <table style="margin: 0 auto 4pt auto; border-collapse: separate; border-spacing: 0;">
                        <tr>
                            <td style="width: 70pt; vertical-align: middle;">
                                <div style="height: 1pt; background-color: #d97706;"></div>
                            </td>
                            <td style="padding: 0 10pt; vertical-align: middle;">
                                @if(file_exists(public_path('images/logo/bran-logo-3d.png')))
                                    <img src="{{ public_path('images/logo/bran-logo-3d.png') }}" class="header-logo" alt="BRAN 3D Seal">
                                @elseif(file_exists(public_path('images/logo/bran-logo.png')))
                                    <img src="{{ public_path('images/logo/bran-logo.png') }}" class="header-logo" alt="BRAN Official Seal">
                                @endif
                            </td>
                            <td style="width: 70pt; vertical-align: middle;">
                                <div style="height: 1pt; background-color: #d97706;"></div>
                            </td>
                        </tr>
                    </table>

                    <div class="institution-title">Brands Academy</div>
                    <div class="institution-subtitle">Nigeria Foundation</div>
                    <div class="legal-subtext">Incorporated Trustee &bull; CAC/IT/No. 7344471 &bull; Federal Republic of Nigeria</div>

                    <div class="ornamental-filigree" style="width: 160pt; height: 1.2pt; margin-bottom: 8pt;"></div>

                    <div class="cert-type">Certificate of Membership</div>
                    <div class="cert-presentation">Be it known to all that having satisfied the statutory requirements of the Foundation</div>

                    <div class="recipient-name">{{ $member->full_name }}</div>

                    <div class="cert-body">
                        has been officially admitted and registered on the Institutional Roll of Brands Academy Nigeria Foundation as an active and recognized
                    </div>

                    <div style="margin-bottom: 4pt;">
                        <span class="category-badge-pill">{{ $member->category_label }}</span>
                    </div>

                    @if($member->institution_or_company)
                        <div class="affiliation-text">
                            Affiliation: {{ $member->designation ? $member->designation . ' • ' : '' }}{{ $member->institution_or_company }} ({{ $member->state }}, {{ $member->country ?? 'Nigeria' }})
                        </div>
                    @else
                        <div class="affiliation-text">
                            Jurisdiction: {{ $member->state }}, {{ $member->country ?? 'Nigeria' }} &bull; Standing: In Good Standing
                        </div>
                    @endif

                    <div class="conferral-proclamation">
                        In witness whereof, by virtue of the authority vested in the Board of Trustees under the Companies and Allied Matters Act, this Certificate is conferred with all honors, rights, and privileges pertaining to this membership grade.
                    </div>

                    <div class="ornamental-filigree"></div>

                    <!-- Signatures & Real Barcodes Table -->
                    <table class="footer-table">
                        <tr>
                            <!-- Signatory 1: Chairman -->
                            <td style="width: 30%;">
                                <div class="sig-container">
                                    @if(file_exists(public_path('images/signatures/prof-samaila-mande.png')))
                                        <img src="{{ public_path('images/signatures/prof-samaila-mande.png') }}" class="sig-img" alt="Prof. Samaila Mande Signature">
                                    @endif
                                </div>
                                <div class="sig-line"></div>
                                <div class="sig-name">Prof. Samaila Mande</div>
                                <div class="sig-title">Chairman, Board of Trustees</div>
                            </td>

                            <!-- Center: Real Scannable Barcode & QR Code in Security Panel -->
                            <td style="width: 40%; text-align: center;">
                                <div class="security-badge-panel">
                                    <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                                        <tr>
                                            <td style="width: 56pt; text-align: center; vertical-align: middle;">
                                                @if(!empty($qrCode))
                                                    <img src="{{ $qrCode }}" class="qr-img" alt="Scannable QR Code" />
                                                @endif
                                            </td>
                                            <td style="text-align: center; vertical-align: middle; padding-left: 6pt;">
                                                @if(!empty($barcode128))
                                                    <img src="{{ $barcode128 }}" class="barcode-img" alt="Code-128 Linear Barcode" />
                                                @endif
                                                <div style="font-size: 7.5pt; font-family: monospace; font-weight: bold; color: #0f172a; margin-top: 2pt; letter-spacing: 0.5px;">
                                                    MEMBER ID: {{ $member->member_number }}
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="font-size: 6pt; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 2pt;">
                                        Officially Verifiable Credential
                                    </div>
                                </div>
                            </td>

                            <!-- Signatory 2: Secretary -->
                            <td style="width: 30%;">
                                <div class="sig-container">
                                    @if(file_exists(public_path('images/signatures/titus-eveshoyan.png')))
                                        <img src="{{ public_path('images/signatures/titus-eveshoyan.png') }}" class="sig-img" alt="Titus Eveshoyan Signature">
                                    @endif
                                </div>
                                <div class="sig-line"></div>
                                <div class="sig-name">Titus Eveshoyan</div>
                                <div class="sig-title">Secretary to the Board &amp; Registrar</div>
                            </td>
                        </tr>
                    </table>

                    <!-- Security & Verification Metadata -->
                    <table class="meta-table">
                        <tr>
                            <td style="text-align: left; width: 33%;">
                                <strong>Date Admitted:</strong> {{ $member->joined_at ? $member->joined_at->format('F d, Y') : now()->format('F d, Y') }}
                            </td>
                            <td style="text-align: center; width: 34%;">
                                <strong>Status:</strong> Active Member in Good Standing
                            </td>
                            <td style="text-align: right; width: 33%;">
                                <strong>Verify:</strong> {{ $verifyUrl }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
