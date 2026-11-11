<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Official CPD Transcript - {{ $member->full_name }} ({{ $member->member_number }})</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 24pt 24pt 24pt 24pt;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #0f172a;
            background: #ffffff;
            font-size: 8.5pt;
            line-height: 1.35;
        }

        /* Container Border Frame */
        .page-frame {
            border: 2pt solid #0f172a;
            padding: 16pt;
            min-height: 770pt;
            position: relative;
        }
        .inner-frame {
            border: 0.75pt solid #d97706;
            padding: 12pt;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 2pt solid #0f172a;
            padding-bottom: 10pt;
            margin-bottom: 12pt;
        }
        .institution-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: #1d4ed8;
            letter-spacing: 1.5pt;
            text-transform: uppercase;
        }
        .main-title {
            font-size: 14pt;
            font-weight: 800;
            color: #020617;
            margin-top: 3pt;
            margin-bottom: 2pt;
            letter-spacing: -0.2pt;
        }
        .subtitle {
            font-size: 7.5pt;
            color: #64748b;
        }
        .meta-right {
            text-align: right;
            vertical-align: top;
        }
        .crest-seal {
            display: inline-block;
            width: 36pt;
            height: 36pt;
            line-height: 36pt;
            text-align: center;
            background-color: #020617;
            color: #f59e0b;
            font-weight: 900;
            font-size: 13pt;
            border-radius: 18pt;
            border: 1.5pt solid #f59e0b;
            margin-bottom: 4pt;
        }

        /* Practitioner Bio Table */
        .bio-table {
            width: 100%;
            background-color: #f8fafc;
            border: 0.5pt solid #cbd5e1;
            border-radius: 4pt;
            padding: 8pt;
            margin-bottom: 12pt;
        }
        .bio-cell {
            width: 25%;
            vertical-align: top;
            padding: 2pt 4pt;
        }
        .bio-label {
            font-size: 6.5pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            margin-bottom: 1pt;
        }
        .bio-val {
            font-size: 8.5pt;
            font-weight: bold;
            color: #0f172a;
        }

        /* Summary Banner */
        .summary-box {
            background-color: #020617;
            color: #ffffff;
            border: 1pt solid #1e293b;
            border-radius: 4pt;
            padding: 10pt;
            margin-bottom: 12pt;
        }
        .summary-table {
            width: 100%;
        }
        .total-credits {
            font-size: 22pt;
            font-weight: 900;
            color: #fbbf24;
            line-height: 1;
        }
        .total-label {
            font-size: 6.5pt;
            text-transform: uppercase;
            letter-spacing: 1pt;
            color: #94a3b8;
            margin-bottom: 2pt;
        }
        .pillar-card {
            background-color: #0f172a;
            border: 0.5pt solid #334155;
            border-radius: 3pt;
            padding: 4pt 6pt;
            text-align: center;
            width: 18%;
        }
        .pillar-name {
            font-size: 6pt;
            color: #94a3b8;
            display: block;
        }
        .pillar-pts {
            font-size: 9pt;
            font-weight: bold;
            color: #ffffff;
        }

        /* Section Title */
        .section-header {
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            color: #0f172a;
            border-bottom: 1pt solid #cbd5e1;
            padding-bottom: 3pt;
            margin-bottom: 6pt;
        }

        /* Ledger Table */
        .ledger-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14pt;
        }
        .ledger-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5pt 6pt;
            border-bottom: 1pt solid #cbd5e1;
            text-align: left;
        }
        .ledger-table td {
            padding: 5pt 6pt;
            border-bottom: 0.5pt solid #f1f5f9;
            font-size: 7.5pt;
            color: #1e293b;
            vertical-align: middle;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
        .font-mono {
            font-family: 'Courier New', Courier, monospace;
        }

        /* Verification & Signoff Block */
        .signoff-table {
            width: 100%;
            margin-top: 14pt;
            border-top: 1pt solid #cbd5e1;
            padding-top: 10pt;
        }
        .qr-cell {
            width: 80pt;
            vertical-align: middle;
            text-align: center;
        }
        .qr-img {
            width: 65pt;
            height: 65pt;
            border: 0.5pt solid #cbd5e1;
            padding: 2pt;
        }
        .attestation-cell {
            padding-left: 10pt;
            padding-right: 10pt;
            vertical-align: middle;
            font-size: 7pt;
            color: #475569;
            line-height: 1.3;
        }
        .registrar-cell {
            width: 130pt;
            vertical-align: middle;
            text-align: center;
            border-left: 0.5pt solid #e2e8f0;
            padding-left: 8pt;
        }
        .signature-line {
            border-bottom: 1pt solid #0f172a;
            margin: 18pt 10pt 4pt 10pt;
        }
        .registrar-title {
            font-size: 6.5pt;
            color: #64748b;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="page-frame">
        <div class="inner-frame">
            <!-- Header Table -->
            <table class="header-table">
                <tr>
                    <td>
                        <div class="institution-title">Brands Academy Nigeria Foundation</div>
                        <div class="main-title">Official CPD Academic Transcript</div>
                        <div class="subtitle">Continuing Professional Development (CPD) Units Registry &bull; CAC IT Reg. No. 7344471</div>
                    </td>
                    <td class="meta-right">
                        <div class="crest-seal">BA</div>
                        <div style="font-size: 7pt; color: #64748b; font-family: monospace;">Date: {{ now()->format('d M Y') }}</div>
                        <div style="font-size: 7pt; color: #0f172a; font-family: monospace; font-weight: bold;">Ref: {{ $member->member_number }}</div>
                    </td>
                </tr>
            </table>

            <!-- Practitioner Bio Matrix -->
            <table class="bio-table">
                <tr>
                    <td class="bio-cell">
                        <span class="bio-label">Practitioner Name</span>
                        <span class="bio-val">{{ $member->full_name }}</span>
                    </td>
                    <td class="bio-cell">
                        <span class="bio-label">Accreditation Tier</span>
                        <span class="bio-val" style="color: #1d4ed8;">
                            {{ $member->category === 'fellow' ? 'Fellow of Brands Academy (FBA)' : ucwords($member->category) }}
                        </span>
                    </td>
                    <td class="bio-cell">
                        <span class="bio-label">Institution / Practice</span>
                        <span class="bio-val">{{ $member->institution_or_company ?: 'Independent Practitioner' }}</span>
                    </td>
                    <td class="bio-cell">
                        <span class="bio-label">Jurisdiction &amp; Standing</span>
                        <span class="bio-val">{{ $member->state ?: 'Nigeria' }} &bull; Good Standing</span>
                    </td>
                </tr>
            </table>

            <!-- Summary Card -->
            <div class="summary-box">
                <table class="summary-table">
                    <tr>
                        <td style="width: 25%; vertical-align: middle;">
                            <div class="total-label">Validated CPD Credits</div>
                            <div class="total-credits">{{ number_format($totalCpdUnits, 1) }} <span style="font-size: 10pt; color: #cbd5e1; font-weight: normal;">Units</span></div>
                        </td>
                        <td class="pillar-card">
                            <span class="pillar-name">Executive Courses</span>
                            <span class="pillar-pts">{{ $courseUnits }} pts</span>
                            <span style="font-size: 5.5pt; color: #64748b; display: block;">{{ $completedCourses->count() }} completed</span>
                        </td>
                        <td style="width: 1%;"></td>
                        <td class="pillar-card">
                            <span class="pillar-name">Conferences &amp; Summits</span>
                            <span class="pillar-pts">{{ $conferenceUnits }} pts</span>
                            <span style="font-size: 5.5pt; color: #64748b; display: block;">{{ $conferencesAttended->count() }} accredited</span>
                        </td>
                        <td style="width: 1%;"></td>
                        <td class="pillar-card">
                            <span class="pillar-name">Cohort Workshops</span>
                            <span class="pillar-pts">{{ $workshopUnits }} pts</span>
                            <span style="font-size: 5.5pt; color: #64748b; display: block;">{{ $workshopCertificates->count() }} certified</span>
                        </td>
                        <td style="width: 1%;"></td>
                        <td class="pillar-card">
                            <span class="pillar-name">JBSM Papers</span>
                            <span class="pillar-pts">{{ $articleUnits }} pts</span>
                            <span style="font-size: 5.5pt; color: #64748b; display: block;">{{ $publishedArticles->count() }} published</span>
                        </td>
                        <td style="width: 1%;"></td>
                        <td class="pillar-card">
                            <span class="pillar-name">Masterclasses</span>
                            <span class="pillar-pts">{{ $webinarUnits }} pts</span>
                            <span style="font-size: 5.5pt; color: #64748b; display: block;">{{ $webinarsAttended->count() }} sessions</span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Detailed Credit Ledger -->
            <div class="section-header">Verified Academic &amp; Professional Credit Ledger</div>
            <table class="ledger-table">
                <thead>
                    <tr>
                        <th style="width: 44%;">Program / Credential Title</th>
                        <th style="width: 18%;">Activity Pillar</th>
                        <th style="width: 14%;">Date Validated</th>
                        <th style="width: 14%;">Ref. Code</th>
                        <th style="width: 10%;" class="text-right">CPD Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedCourses as $c)
                        <tr>
                            <td class="font-bold">{{ $c->course->title }}</td>
                            <td style="color: #64748b;">Executive Short Course</td>
                            <td>{{ $c->completed_at ? $c->completed_at->format('d M Y') : 'Completed' }}</td>
                            <td class="font-mono" style="font-size: 6.5pt;">{{ $c->certificate?->certificate_number ?: 'VERIFIED' }}</td>
                            <td class="text-right font-bold font-mono">10.0</td>
                        </tr>
                    @endforeach

                    @foreach($conferencesAttended as $d)
                        <tr>
                            <td class="font-bold">{{ $d->conference->title }}</td>
                            <td style="color: #64748b;">National Plenary Summit</td>
                            <td>{{ $d->created_at->format('d M Y') }}</td>
                            <td class="font-mono" style="font-size: 6.5pt;">{{ $d->badge_code }}</td>
                            <td class="text-right font-bold font-mono">15.0</td>
                        </tr>
                    @endforeach

                    @foreach($workshopCertificates as $cert)
                        <tr>
                            <td class="font-bold">{{ $cert->workshop ? $cert->workshop->title : 'Executive Cohort Workshop' }}</td>
                            <td style="color: #64748b;">Executive Workshop Cohort</td>
                            <td>{{ $cert->issued_at ? $cert->issued_at->format('d M Y') : 'Certified' }}</td>
                            <td class="font-mono" style="font-size: 6.5pt;">{{ $cert->certificate_number }}</td>
                            <td class="text-right font-bold font-mono">25.0</td>
                        </tr>
                    @endforeach

                    @foreach($publishedArticles as $art)
                        <tr>
                            <td class="font-bold">{{ $art->title }}</td>
                            <td style="color: #64748b;">JBSM Research Manuscript</td>
                            <td>{{ $art->published_at ? $art->published_at->format('d M Y') : 'Published' }}</td>
                            <td class="font-mono" style="font-size: 6.5pt;">DOI: {{ $art->doi ?: '10.5982/jbsm' }}</td>
                            <td class="text-right font-bold font-mono">20.0</td>
                        </tr>
                    @endforeach

                    @foreach($webinarsAttended as $w)
                        <tr>
                            <td class="font-bold">{{ $w->webinar->title }}</td>
                            <td style="color: #64748b;">Executive Masterclass / AMA</td>
                            <td>{{ $w->webinar->starts_at->format('d M Y') }}</td>
                            <td class="font-mono" style="font-size: 6.5pt;">BANF-WEB-{{ $w->webinar_id }}</td>
                            <td class="text-right font-bold font-mono">2.0</td>
                        </tr>
                    @endforeach

                    @if($totalCpdUnits == 0)
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 16pt; color: #94a3b8;">
                                No accredited CPD activities logged yet. Credits are automatically recorded upon completion of courses, workshops, conference delegations, masterclasses, and published papers.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Signoff & Security Block -->
            <table class="signoff-table">
                <tr>
                    <td class="qr-cell">
                        <img src="{{ $qrCode }}" class="qr-img" alt="Registry QR Code">
                        <div style="font-size: 5.5pt; color: #64748b; margin-top: 2pt;">Scan to Verify Online</div>
                    </td>
                    <td class="attestation-cell">
                        <strong style="color: #0f172a; display: block; margin-bottom: 2pt;">Official Statutory Attestation:</strong>
                        This academic and professional record has been verified and registered by Brands Academy Nigeria Foundation under Incorporated Trustees Act (CAC IT No. 7344471). All CPD units represent accredited hours approved for statutory compliance, academic tenure review, and certified corporate board qualification.
                        <div style="margin-top: 4pt; font-family: monospace; font-size: 6.5pt; color: #1d4ed8;">
                            Verification URL: {{ $verifyUrl }}
                        </div>
                    </td>
                    <td class="registrar-cell">
                        <div style="font-size: 8pt; font-weight: bold; color: #0f172a;">Prof. Samaila Mande</div>
                        <div class="signature-line"></div>
                        <div class="registrar-title">Chairman, Board of Trustees</div>
                        <div style="font-size: 6pt; color: #94a3b8; margin-top: 2pt;">Brands Academy Nigeria Foundation</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
