<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Achievement - Brands Academy Nigeria Foundation</title>
    <style>
        @page {
            size: 297mm 210mm;
            margin: 8mm;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #0f172a;
            margin: 0;
            padding: 0;
            width: 281mm;
            height: 194mm;
        }

        .cert-outer-box {
            width: 281mm;
            height: 194mm;
            border: 3.5px solid #0f172a;
            padding: 3.5px;
            background: #ffffff;
            position: relative;
        }

        .cert-inner-box {
            border: 1.5px solid #d97706;
            width: 100%;
            height: 100%;
            padding: 7mm 12mm 4mm 12mm;
            text-align: center;
            position: relative;
            background: #ffffff;
        }

        /* Ornamental Corner Accents */
        .corner {
            position: absolute;
            width: 14px;
            height: 14px;
            border-color: #d97706;
            border-style: solid;
        }
        .corner-tl { top: 3px; left: 3px; border-width: 2.5px 0 0 2.5px; }
        .corner-tr { top: 3px; right: 3px; border-width: 2.5px 2.5px 0 0; }
        .corner-bl { bottom: 3px; left: 3px; border-width: 0 0 2.5px 2.5px; }
        .corner-br { bottom: 3px; right: 3px; border-width: 0 2.5px 2.5px 0; }

        .header-logo {
            width: 54px;
            height: 54px;
            margin: 0 auto 5px auto;
            display: block;
        }

        .institution-title {
            font-size: 19pt;
            font-weight: 800;
            letter-spacing: 3px;
            color: #0f172a;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .institution-subtitle {
            font-size: 8.5pt;
            letter-spacing: 2px;
            color: #b45309;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 3px;
            margin-bottom: 3px;
        }

        .legal-subtext {
            font-size: 6.8pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 10px;
        }

        .gold-divider {
            width: 180px;
            height: 1.5px;
            background-color: #d97706;
            margin: 0 auto 12px auto;
        }

        .cert-type {
            font-size: 10.5pt;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #334155;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .cert-presentation {
            font-size: 8.8pt;
            color: #64748b;
            font-style: italic;
            margin-bottom: 10px;
        }

        .recipient-name {
            font-size: 24pt;
            font-weight: 800;
            color: #0f172a;
            border-bottom: 2px solid #f59e0b;
            display: inline-block;
            padding: 0 30px 4px 30px;
            margin-bottom: 11px;
            letter-spacing: 0.5px;
        }

        .cert-body {
            font-size: 9.2pt;
            line-height: 1.5;
            color: #334155;
            max-width: 720px;
            margin: 0 auto 8px auto;
        }

        .program-title {
            font-size: 12pt;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .footer-table td {
            vertical-align: bottom;
            text-align: center;
        }

        .sig-container {
            height: 52px;
            vertical-align: bottom;
            text-align: center;
        }

        .sig-img {
            height: 46px;
            max-width: 180px;
            display: block;
            margin: 0 auto -6px auto;
        }

        .sig-line {
            width: 180px;
            border-top: 1.2px solid #334155;
            margin: 0 auto 4px auto;
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
            padding: 0 4px;
        }

        .barcode-img {
            height: 32px;
            max-width: 150px;
            display: block;
            margin: 0 auto 3px auto;
        }

        .qr-img {
            width: 50px;
            height: 50px;
            display: inline-block;
            border: 1px solid #cbd5e1;
            padding: 2px;
            background: #ffffff;
            margin-bottom: 4px;
        }

        .meta-table {
            width: 100%;
            margin-top: 12px;
            font-size: 7pt;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 4px;
        }
    </style>
</head>
<body>

    <div class="cert-outer-box">
        <div class="cert-inner-box">
            <!-- Ornamental Corner Accents -->
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>

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
                                    <div style="font-size: 6.8pt; font-family: monospace; font-weight: bold; color: #0f172a; margin-top: 2px;">
                                        ID: {{ $certificate->certificate_number }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div style="font-size: 6.2pt; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 3px;">
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
                    <td style="text-align: left; width: 35%;">
                        <strong>Date Issued:</strong> {{ $certificate->issued_at->format('F d, Y') }}
                    </td>
                    <td style="text-align: center; width: 30%;">
                        <strong>Status:</strong> Valid &bull; In Good Standing
                    </td>
                    <td style="text-align: right; width: 35%;">
                        <strong>Verify:</strong> {{ $verifyUrl }}
                    </td>
                </tr>
            </table>

        </div>
    </div>

</body>
</html>
