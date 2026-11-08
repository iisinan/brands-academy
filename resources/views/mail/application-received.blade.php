<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Received - Brands Academy Nigeria Foundation</title>
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
                Incorporated Trustee &bull; RC / IT No. 7344471 &bull; Office of Admissions
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 30px; font-size: 15px; line-height: 1.6;">
            <p style="font-size: 17px; font-weight: bold; color: #0f172a; margin-top: 0;">
                Dear {{ $application->applicant_name }},
            </p>
            
            <p>
                Thank you for applying to <strong>Brands Academy Nigeria Foundation</strong>. This email confirms that our Admissions Committee has officially received your application deliverables and statement of purpose.
            </p>

            <div style="background-color: #f1f5f9; border-left: 4px solid #3b82f6; padding: 18px 20px; margin: 20px 0; border-radius: 4px;">
                <div style="font-size: 12px; color: #2563eb; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">
                    Application Record &bull; Ref #{{ $application->id }}
                </div>
                <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                    {{ $application->workshop->title }}
                </div>
                <div style="font-size: 13px; color: #b45309; font-weight: 600; margin-top: 2px;">
                    {{ $application->workshop->track_label }}
                </div>
                <div style="font-size: 12px; color: #475569; margin-top: 8px; line-height: 1.6;">
                    <strong>Delivery Mode:</strong> {{ ucfirst($application->workshop->delivery_mode) }}<br>
                    <strong>Cohort Begins:</strong> {{ $application->workshop->starts_at->format('F d, Y') }}<br>
                    <strong>Funding / Scholarship Request:</strong> {{ $application->scholarship_requested ? 'Tuition Subsidy / Scholarship Requested' : ($application->workshop->fee_type == 'free' ? '100% Free Foundation Track' : 'Standard Enrolment') }}<br>
                    <strong>Review Status:</strong> Under Admissions Review (Pending)
                </div>
            </div>

            <h3 style="color: #0f172a; font-size: 15px; margin-top: 24px; margin-bottom: 8px;">What Happens Next?</h3>
            <p style="font-size: 13px; color: #475569; line-height: 1.6;">
                Our committee evaluates submissions based on commitment, career alignment, and portfolio potential. You will receive an email update regarding your admission decision before the programme begins.
            </p>

            <div style="text-align: center; margin: 28px 0;">
                <a href="{{ route('workshops.show', $application->workshop->slug) }}" style="display: inline-block; background-color: #0f172a; color: #fbbf24; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; font-size: 13px; border: 1px solid #d97706;">
                    View Programme Syllabus &amp; Updates
                </a>
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Best regards,<br>
                <strong>Admissions &amp; Credentials Committee</strong><br>
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
