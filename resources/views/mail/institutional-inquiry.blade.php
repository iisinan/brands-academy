<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Institutional Partnerships - Brands Academy Nigeria Foundation</title>
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
                Incorporated Trustee &bull; Office of Corporate Partnerships &amp; Advisory
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 30px; font-size: 15px; line-height: 1.6;">
            @if ($isInternalAlert)
                <p style="font-size: 17px; font-weight: bold; color: #0f172a; margin-top: 0;">
                    New Institutional Partnership Lead
                </p>
                <p>
                    A new partnership / corporate licensing inquiry has just been submitted on the Brands Academy portal:
                </p>
            @else
                <p style="font-size: 17px; font-weight: bold; color: #0f172a; margin-top: 0;">
                    Dear {{ $inquiry->contact_person }},
                </p>
                <p>
                    Thank you for contacting <strong>Brands Academy Nigeria Foundation</strong> on behalf of <strong>{{ $inquiry->organization_name }}</strong>.
                </p>
                <p>
                    We have received your institutional inquiry. Our strategic advisory and executive training team will review your specifications and contact you within 48 business hours.
                </p>
            @endif

            <div style="background-color: #f1f5f9; border-left: 4px solid #d97706; padding: 18px 20px; margin: 20px 0; border-radius: 4px;">
                <div style="font-size: 12px; color: #b45309; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">
                    Inquiry Summary
                </div>
                <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                    {{ $inquiry->organization_name }}
                </div>
                <div style="font-size: 12px; color: #475569; margin-top: 8px; line-height: 1.6;">
                    <strong>Contact Person:</strong> {{ $inquiry->contact_person }}<br>
                    <strong>Email:</strong> {{ $inquiry->email }} &bull; <strong>Phone:</strong> {{ $inquiry->phone }}<br>
                    <strong>Sector:</strong> {{ ucfirst(str_replace('_', ' ', $inquiry->organization_type)) }}<br>
                    <strong>Solution Interest:</strong> {{ ucfirst(str_replace('_', ' ', $inquiry->solution_interest)) }}<br>
                    @if ($inquiry->estimated_cohort_size)
                        <strong>Estimated Cohort Size:</strong> {{ $inquiry->estimated_cohort_size }} learners<br>
                    @endif
                    @if ($inquiry->target_timeline)
                        <strong>Target Timeline:</strong> {{ $inquiry->target_timeline }}<br>
                    @endif
                </div>
            </div>

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 16px 20px; border-radius: 6px; font-size: 13px; color: #334155; line-height: 1.6;">
                <strong style="color: #0f172a; font-size: 12px; text-transform: uppercase;">Message / Objectives:</strong><br>
                {!! nl2br(e($inquiry->message)) !!}
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Warm regards,<br>
                <strong>Office of Strategic Partnerships &amp; Advisory</strong><br>
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
