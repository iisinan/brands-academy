<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Portfolio Evaluation - Brands Academy Nigeria Foundation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; color: #1e293b; padding: 24px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        
        <!-- Header -->
        <div style="background-color: #0f172a; padding: 30px; text-align: center; border-bottom: 3px solid #d97706;">
            <img src="{{ asset('images/logo/bran-logo.png') }}" width="56" height="56" alt="Brands Academy Crest" style="margin: 0 auto 10px auto; display: block; border-radius: 50%;">
            <h1 style="color: #ffffff; margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px;">
                Brands Academy
            </h1>
            <p style="color: #fbbf24; margin: 4px 0 0 0; font-size: 13px; font-weight: bold; text-transform: uppercase;">
                Nigeria Foundation
            </p>
            <p style="color: #94a3b8; margin: 8px 0 0 0; font-size: 11px;">
                Faculty of Brand Practice &bull; Academic Mentorship Registry
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 30px; font-size: 15px; line-height: 1.6;">
            <p style="font-size: 17px; font-weight: bold; color: #0f172a; margin-top: 0;">
                Dear {{ $submission->application->applicant_name }},
            </p>
            
            <p>
                Your mentor has completed the assessment of your practical project submission for <strong>{{ $submission->workshop->title ?? 'Brands Academy Programme' }}</strong>:
            </p>

            <div style="background-color: #f1f5f9; border-left: 4px solid {{ $submission->status === 'approved' ? '#10b981' : '#f59e0b' }}; padding: 18px 20px; margin: 20px 0; border-radius: 4px;">
                <div style="font-size: 12px; color: {{ $submission->status === 'approved' ? '#059669' : '#b45309' }}; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">
                    Evaluation Status: {{ $submission->status === 'approved' ? 'Project Approved' : 'Revisions Requested' }}
                </div>
                <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                    {{ $submission->title }}
                </div>
                <div style="font-size: 12px; color: #475569; margin-top: 8px; line-height: 1.6;">
                    <strong>Grade Awarded:</strong> {{ $submission->grade ? ucfirst($submission->grade) : 'Pending' }}<br>
                    <strong>Evaluated By:</strong> {{ $submission->reviewed_by ?? 'Foundation Faculty Mentor' }}<br>
                    <strong>Date:</strong> {{ $submission->reviewed_at?->format('F d, Y') ?? now()->format('F d, Y') }}
                </div>
            </div>

            <h3 style="color: #0f172a; font-size: 15px; margin-top: 24px; margin-bottom: 8px;">Mentor Feedback &amp; Commentary</h3>
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 16px 20px; border-radius: 6px; font-size: 13px; color: #334155; line-height: 1.6;">
                {!! nl2br(e($submission->mentor_feedback)) !!}
            </div>

            @if ($submission->status === 'approved')
                <p style="font-size: 13px; color: #059669; font-weight: 600; margin-top: 18px;">
                    Congratulations! Your project has met our foundation standards. The Office of the Registrar will issue your official verified Certificate of Achievement.
                </p>
            @else
                <p style="font-size: 13px; color: #b45309; font-weight: 600; margin-top: 18px;">
                    Please incorporate the mentor suggestions and re-submit your updated project deliverables through your member dashboard.
                </p>
            @endif

            <div style="text-align: center; margin: 28px 0;">
                <a href="{{ route('member.dashboard') }}" style="display: inline-block; background-color: #0f172a; color: #fbbf24; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; font-size: 13px; border: 1px solid #d97706;">
                    View Member Dashboard
                </a>
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Warm regards,<br>
                <strong>Faculty &amp; Mentor Board</strong><br>
                Brands Academy Nigeria Foundation<br>
                Kaduna, Nigeria
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8fafc; padding: 20px 30px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            No. 27C, Ilorin Crescent, Ali-Akilu West, Marafa, Kaduna State, Nigeria.
        </div>

    </div>
</body>
</html>
