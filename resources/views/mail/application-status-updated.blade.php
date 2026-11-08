<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admissions Update - Brands Academy Nigeria Foundation</title>
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

            @if ($status === 'waitlisted')
                <p>
                    Thank you for applying to <strong>Brands Academy Nigeria Foundation</strong>. Due to strict cohort capacity caps to ensure intimate mentor pairing, we are unable to offer immediate admission into:
                </p>

                <div style="background-color: #fefce8; border-left: 4px solid #eab308; padding: 18px 20px; margin: 20px 0; border-radius: 4px;">
                    <div style="font-size: 12px; color: #854d0e; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">
                        Priority Waitlist Status
                    </div>
                    <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                        {{ $application->workshop->title }}
                    </div>
                    <div style="font-size: 13px; color: #b45309; font-weight: 600; margin-top: 2px;">
                        {{ $application->workshop->track_label }}
                    </div>
                </div>

                <p style="font-size: 13px; color: #475569; line-height: 1.6;">
                    Your profile has been placed on our <strong>Priority Waitlist</strong>. If an admitted candidate defers or an additional seat becomes available before commencement on {{ $application->workshop->starts_at->format('F d, Y') }}, our committee will contact you immediately.
                </p>
            @else
                <p>
                    Thank you for the time and effort invested in submitting your application for:
                </p>

                <div style="background-color: #f8fafc; border-left: 4px solid #64748b; padding: 18px 20px; margin: 20px 0; border-radius: 4px;">
                    <div style="font-size: 12px; color: #475569; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">
                        Admissions Decision
                    </div>
                    <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                        {{ $application->workshop->title }}
                    </div>
                    <div style="font-size: 13px; color: #b45309; font-weight: 600; margin-top: 2px;">
                        {{ $application->workshop->track_label }}
                    </div>
                </div>

                <p style="font-size: 13px; color: #475569; line-height: 1.6;">
                    After careful evaluation by the Admissions Committee, we regret to inform you that we cannot offer you a placement in this cohort. Competition for cohort seats is rigorous, and this decision does not reflect upon your potential as a brand practitioner.
                </p>

                <p style="font-size: 13px; color: #475569; line-height: 1.6;">
                    We encourage you to continue refining your portfolio deliverables and explore our upcoming foundational programmes and public masterclasses.
                </p>
            @endif

            @if ($application->admin_notes)
                <div style="background-color: #f1f5f9; padding: 14px 18px; border-radius: 6px; margin: 20px 0; font-size: 12px; color: #334155;">
                    <strong style="color: #0f172a;">Committee Feedback / Notes:</strong><br>
                    {{ $application->admin_notes }}
                </div>
            @endif

            <div style="text-align: center; margin: 28px 0;">
                <a href="{{ route('workshops.index') }}" style="display: inline-block; background-color: #0f172a; color: #fbbf24; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; font-size: 13px; border: 1px solid #d97706;">
                    Explore Upcoming Cohorts
                </a>
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Sincerely,<br>
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
