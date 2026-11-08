<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offer of Admission - Brands Academy Nigeria Foundation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; color: #1e293b; padding: 24px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
        
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
                We are delighted to offer you admission into the upcoming cohort of <strong>Brands Academy Nigeria Foundation</strong>:
            </p>

            <div style="background-color: #f1f5f9; border-left: 4px solid #10b981; padding: 18px 20px; margin: 20px 0; border-radius: 4px;">
                <div style="font-size: 12px; color: #059669; text-transform: uppercase; font-weight: bold;">Admission Offer Confirmed</div>
                <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                    {{ $application->workshop->title }}
                </div>
                <div style="font-size: 13px; color: #b45309; font-weight: 600; margin-top: 2px;">
                    {{ $application->workshop->track_label }}
                </div>
                <div style="font-size: 12px; color: #475569; margin-top: 8px; line-height: 1.6;">
                    <strong>Delivery Mode:</strong> {{ ucfirst($application->workshop->delivery_mode) }}<br>
                    <strong>Commencement Date:</strong> {{ $application->workshop->starts_at->format('F d, Y') }}<br>
                    <strong>Tuition / Funding Status:</strong> {{ $application->scholarship_requested ? 'Foundation Educational Subsidy / Scholarship Approved' : ($application->workshop->fee_type == 'free' ? '100% Free Track' : 'Standard Enrolment') }}
                </div>
            </div>

            <h3 style="color: #0f172a; font-size: 15px; margin-top: 24px; margin-bottom: 8px;">Next Steps: Orientation & Mentor Pairing (Step 5)</h3>
            <p style="font-size: 13px; color: #475569;">
                Our curriculum pairs each learner with practical guided support from industry practitioners. You will receive an invitation to the virtual orientation session shortly before training begins.
            </p>

            <div style="text-align: center; margin: 28px 0;">
                <a href="{{ route('workshops.show', $application->workshop->slug) }}" style="display: inline-block; background-color: #0f172a; color: #fbbf24; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; font-size: 13px;">
                    View Programme Details
                </a>
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Congratulations once again on your selection.<br>
                <strong>Admissions & Credentials Committee</strong><br>
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
