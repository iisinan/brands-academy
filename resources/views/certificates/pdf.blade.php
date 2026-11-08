<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Achievement - Brands Academy Nigeria Foundation</title>
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

        /* Sovereign Double Ornamental Frame */
        .outer-border {
            position: absolute;
            top: 18pt;
            left: 18pt;
            width: 805.89pt;
            height: 559.28pt;
            border: 3.5pt solid #0f172a;
        }

        .inner-border {
            position: absolute;
            top: 4.5pt;
            left: 4.5pt;
            width: 793.89pt;
            height: 547.28pt;
            border: 1.5pt solid #d97706;
        }

        /* Ornamental Corner Accents */
        .corner {
            position: absolute;
            width: 15pt;
            height: 15pt;
            border-color: #d97706;
            border-style: solid;
        }
        .corner-tl { top: 3pt; left: 3pt; border-width: 2.5pt 0 0 2.5pt; }
        .corner-tr { top: 3pt; right: 3pt; border-width: 2.5pt 2.5pt 0 0; }
        .corner-bl { bottom: 3pt; left: 3pt; border-width: 0 0 2.5pt 2.5pt; }
        .corner-br { bottom: 3pt; right: 3pt; border-width: 0 2.5pt 2.5pt 0; }

        .content-box {
            padding: 14pt 24pt 8pt 24pt;
            text-align: center;
        }

        .header-logo {
            width: 52pt;
            height: 52pt;
            margin: 0 auto 5pt auto;
            display: block;
        }

        .institution-title {
            font-size: 19pt;
            font-weight: 800;
            letter-spacing: 3.5px;
            color: #0f172a;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .institution-subtitle {
            font-size: 8.5pt;
            letter-spacing: 2.5px;
            color: #b45309;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 2pt;
            margin-bottom: 2pt;
        }

        .legal-subtext {
            font-size: 6.8pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 9pt;
        }

        .gold-divider {
            width: 170pt;
            height: 1.5pt;
            background-color: #d97706;
            margin: 0 auto 10pt auto;
        }

        .cert-type {
            font-size: 10.5pt;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #334155;
            font-weight: 700;
            margin-bottom: 5pt;
        }

        .cert-presentation {
            font-size: 8.8pt;
            color: #64748b;
            font-style: italic;
            margin-bottom: 8pt;
        }

        .recipient-name {
            font-size: 24pt;
            font-weight: 800;
            color: #0f172a;
            border-bottom: 2pt solid #f59e0b;
            display: inline-block;
            padding: 0 28pt 3pt 28pt;
            margin-bottom: 10pt;
            letter-spacing: 0.5px;
        }

        .cert-body {
            font-size: 9pt;
            line-height: 1.45;
            color: #334155;
            max-width: 580pt;
            margin: 0 auto 7pt auto;
        }

        .program-title {
            font-size: 12pt;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 14pt;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4pt;
        }

        .footer-table td {
            vertical-align: bottom;
            text-align: center;
        }

        .sig-container {
            height: 48pt;
            vertical-align: bottom;
            text-align: center;
        }

        .sig-img {
            height: 44pt;
            max-width: 160pt;
            display: block;
            margin: 0 auto -5pt auto;
        }

        .sig-line {
            width: 160pt;
            border-top: 1.2pt solid #334155;
            margin: 0 auto 3pt auto;
        }

        .sig-name {
            font-size: 9pt;
            font-weight: 700;
            color: #0f172a;
        }

        .sig-title {
            font-size: 7.5pt;
            color: #64748b;
        }

        .barcode-box {
            text-align: center;
            padding: 0 4pt;
        }

        .barcode-img {
            height: 30pt;
            max-width: 145pt;
            display: block;
            margin: 0 auto 2pt auto;
        }

        .qr-img {
            width: 46pt;
            height: 46pt;
            display: inline-block;
            border: 1pt solid #cbd5e1;
            padding: 2pt;
            background: #ffffff;
            margin-bottom: 3pt;
        }

        .meta-table {
            width: 100%;
            margin-top: 10pt;
            font-size: 6.8pt;
            color: #64748b;
            border-top: 0.8pt solid #e2e8f0;
            padding-top: 3pt;
        }
    </style>
</head>
<body>

    <div class="outer-border">
        <div class="inner-border">
            <!-- Ornamental Corner Accents -->
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>

            <div class="content-box">
                <!-- 3D Seal Medallion Logo -->
                @if(file_exists(public_path('images/logo/bran-logo-3d.png')))
                    <img src="{{ public_path('images/logo/bran-logo-3d.png') }}" class="header-logo" alt="BRAN 3D Seal">
                @elseif(file_exists(public_path('images/logo/bran-logo.png')))
                    <img src="{{ public_path('images/logo/bran-logo.png') }}" class="header-logo" alt="BRAN Official Seal">
                @endif

                <div class="institution-title">Brands Academy</div>
                <div class="institution-subtitle">Nigeria Foundation</div>
                <div class="legal-subtext">Incorporated Trustee &bull; RC / IT No. 7344471 &bull; Federal Republic of Nigeria</div>

                <div class="gold-divider"></div>

                <div class="cert-type">Certificate of Achievement</div>
                <div class="cert-presentation">This is to certify that</div>

                <div class="recipient-name">{{ $certificate->recipient_name }}</div>

                <div class="cert-body">
                    has successfully completed all prescribed curricula, practical masterclasses, and executive portfolio assessments established by the Foundation's Board of Trustees for
                </div>

                <div class="program-title">{{ $certificate->track_tier }}</div>

                <!-- Signatures & Real Barcodes Table -->
                <table class="footer-table">
                    <tr>
                        <!-- Signatory 1: Chairman -->
                        <td style="width: 32%;">
                            <div class="sig-container">
                                @if(file_exists(public_path('images/signatures/prof-samaila-mande.png')))
                                    <img src="{{ public_path('images/signatures/prof-samaila-mande.png') }}" class="sig-img" alt="Prof. Samaila Mande Signature">
                                @endif
                            </div>
                            <div class="sig-line"></div>
                            <div class="sig-name">Prof. Samaila Mande</div>
                            <div class="sig-title">Chairman, Board of Trustees</div>
                        </td>

                        <!-- Center: Real Scannable Barcode & QR Code -->
                        <td style="width: 36%;" class="barcode-box">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                        @if(!empty($qrCode))
                                            <img src="{{ $qrCode }}" class="qr-img" alt="Scannable QR Code" />
                                        @endif
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        @if(!empty($barcode128))
                                            <img src="{{ $barcode128 }}" class="barcode-img" alt="Code-128 Linear Barcode" />
                                        @endif
                                        <div style="font-size: 6.5pt; font-family: monospace; font-weight: bold; color: #0f172a; margin-top: 1pt;">
                                            ID: {{ $certificate->certificate_number }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div style="font-size: 6pt; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2pt;">
                                Cryptographically Verifiable Credential
                            </div>
                        </td>

                        <!-- Signatory 2: Secretary -->
                        <td style="width: 32%;">
                            <div class="sig-container">
                                @if(file_exists(public_path('images/signatures/titus-eveshoyan.png')))
                                    <img src="{{ public_path('images/signatures/titus-eveshoyan.png') }}" class="sig-img" alt="Titus Eveshoyan Signature">
                                @endif
                            </div>
                            <div class="sig-line"></div>
                            <div class="sig-name">Titus Eveshoyan</div>
                            <div class="sig-title">Secretary to the Board</div>
                        </td>
                    </tr>
                </table>

                <!-- Security & Verification Metadata -->
                <table class="meta-table">
                    <tr>
                        <td style="text-align: left; width: 33%;">
                            <strong>Date Issued:</strong> {{ $certificate->issued_at->format('F d, Y') }}
                        </td>
                        <td style="text-align: center; width: 34%;">
                            <strong>Status:</strong> Valid &bull; In Good Standing
                        </td>
                        <td style="text-align: right; width: 33%;">
                            <strong>Verify:</strong> {{ $verifyUrl }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
