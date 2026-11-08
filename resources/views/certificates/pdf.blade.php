<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Achievement - Brands Academy Nigeria Foundation</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #fbfbfd;
            color: #0f172a;
            width: 297mm;
            height: 210mm;
            padding: 12mm;
            position: relative;
        }
        .outer-border {
            border: 4px solid #1e293b;
            height: 100%;
            padding: 4mm;
            position: relative;
            background: #ffffff;
        }
        .inner-border {
            border: 1.5px solid #d97706;
            height: 100%;
            padding: 10mm 14mm;
            text-align: center;
            position: relative;
        }
        .corner-decoration {
            position: absolute;
            width: 18px;
            height: 18px;
            border: 3px solid #d97706;
        }
        .corner-tl { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .corner-tr { top: -2px; right: -2px; border-left: none; border-bottom: none; }
        .corner-bl { bottom: -2px; left: -2px; border-right: none; border-top: none; }
        .corner-br { bottom: -2px; right: -2px; border-left: none; border-top: none; }

        .institution-title {
            font-size: 20pt;
            font-weight: 800;
            letter-spacing: 2.5px;
            color: #0f172a;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .institution-subtitle {
            font-size: 9pt;
            letter-spacing: 1.8px;
            color: #b45309;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .legal-subtext {
            font-size: 7.5pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 14px;
        }
        .divider {
            width: 140px;
            height: 2px;
            background: linear-gradient(to right, #ffffff, #d97706, #ffffff);
            margin: 0 auto 16px auto;
        }
        .cert-type {
            font-size: 11pt;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #475569;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .cert-presentation {
            font-size: 9.5pt;
            color: #64748b;
            font-style: italic;
            margin-bottom: 12px;
        }
        .recipient-name {
            font-size: 28pt;
            font-weight: 800;
            color: #0f172a;
            border-bottom: 2px solid #f59e0b;
            display: inline-block;
            padding: 0 35px 6px 35px;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }
        .cert-body {
            font-size: 10pt;
            line-height: 1.55;
            color: #334155;
            max-width: 780px;
            margin: 0 auto 16px auto;
        }
        .program-title {
            font-size: 13pt;
            font-weight: 700;
            color: #0f172a;
            margin: 4px 0 14px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
        }
        .footer-table td {
            vertical-align: bottom;
            text-align: center;
        }
        .sig-line {
            width: 190px;
            border-top: 1.5px solid #334155;
            margin: 0 auto 5px auto;
        }
        .sig-name {
            font-size: 9.5pt;
            font-weight: 700;
            color: #0f172a;
        }
        .sig-title {
            font-size: 8pt;
            color: #64748b;
        }
        .seal-box {
            display: inline-block;
            border: 2px solid #d97706;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            padding-top: 16px;
            color: #b45309;
            font-size: 7pt;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.2;
        }
        .meta-bar {
            position: absolute;
            bottom: 4mm;
            left: 14mm;
            right: 14mm;
            display: flex;
            justify-content: space-between;
            font-size: 7pt;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 4px;
        }
    </style>
</head>
<body>

    <div class="outer-border">
        <div class="corner-decoration corner-tl"></div>
        <div class="corner-decoration corner-tr"></div>
        <div class="corner-decoration corner-bl"></div>
        <div class="corner-decoration corner-br"></div>

        <div class="inner-border">
            @if(file_exists(public_path('images/logo/bran-logo.png')))
                <img src="{{ public_path('images/logo/bran-logo.png') }}" style="width: 55px; height: 55px; margin: 0 auto 8px auto; display: block;" alt="BRAN Official Seal">
            @endif
            <div class="institution-title">Brands Academy</div>
            <div class="institution-subtitle">Nigeria Foundation</div>
            <div class="legal-subtext">Incorporated Trustee &bull; RC / IT No. 7344471 &bull; Federal Republic of Nigeria</div>
            
            <div class="divider"></div>

            <div class="cert-type">Certificate of Achievement</div>
            <div class="cert-presentation">This is to certify that</div>

            <div class="recipient-name">{{ $certificate->recipient_name }}</div>

            <div class="cert-body">
                has successfully fulfilled all academic curricula, practical assessments, and portfolio benchmarks established by the Foundation's Board of Trustees for
            </div>

            <div class="program-title">{{ $certificate->track_tier }}</div>

            <table class="footer-table">
                <tr>
                    <!-- Signatory 1 -->
                    <td style="width: 32%;">
                        <div class="sig-line"></div>
                        <div class="sig-name">Prof. Samaila Mande</div>
                        <div class="sig-title">Chairman, Board of Trustees</div>
                    </td>

                    <!-- Center Official Seal & QR Code -->
                    <td style="width: 36%;">
                        @if(!empty($qrCode))
                            <img src="{{ $qrCode }}" alt="Verification QR Code" style="width: 65px; height: 65px; display: inline-block; margin-bottom: 2px;" />
                        @else
                            <div class="seal-box">
                                OFFICIAL<br>SEAL<br>BANF
                            </div>
                        @endif
                        <div style="font-size: 7.5pt; color: #64748b; font-weight: 600; margin-top: 3px;">
                            ID: {{ $certificate->certificate_number }}
                        </div>
                    </td>

                    <!-- Signatory 2 -->
                    <td style="width: 32%;">
                        <div class="sig-line"></div>
                        <div class="sig-name">Titus Eveshoyan</div>
                        <div class="sig-title">Secretary to the Board</div>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 14px; font-size: 7.5pt; color: #64748b;">
                <tr>
                    <td style="text-align: left;">
                        <strong>Date Issued:</strong> {{ $certificate->issued_at->format('F d, Y') }}
                    </td>
                    <td style="text-align: right;">
                        <strong>Verify Authenticity:</strong> {{ $verifyUrl }}
                    </td>
                </tr>
            </table>

        </div>
    </div>

</body>
</html>
