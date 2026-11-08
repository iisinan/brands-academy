<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Brands Academy Nigeria Foundation</title>
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
                Incorporated Trustee &bull; RC / IT No. 7344471 &bull; Office of the Registrar
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 30px; font-size: 15px; line-height: 1.6;">
            <p style="font-size: 17px; font-weight: bold; color: #0f172a; margin-top: 0;">
                Dear {{ $user->name }},
            </p>
            
            <p>
                Congratulations and welcome! Your email address has been verified, and your membership account with <strong>Brands Academy Nigeria Foundation</strong> is now officially active.
            </p>

            <div style="background-color: #f1f5f9; border-left: 4px solid #10b981; padding: 18px 20px; margin: 20px 0; border-radius: 4px;">
                <div style="font-size: 12px; color: #059669; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">
                    Official Member Credentials
                </div>
                <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                    {{ $member->member_number ?? 'BANF-MBR-ACTIVE' }}
                </div>
                <div style="font-size: 13px; color: #b45309; font-weight: 600; margin-top: 2px;">
                    {{ $member->category_label ?? 'Foundation Member' }}
                </div>
                <div style="font-size: 12px; color: #475569; margin-top: 8px; line-height: 1.6;">
                    <strong>Registered Name:</strong> {{ $user->name }}<br>
                    <strong>Email:</strong> {{ $user->email }}<br>
                    <strong>Location:</strong> {{ $member->state ?? 'Kaduna' }}, {{ $member->country ?? 'Nigeria' }}<br>
                    <strong>Portal Access:</strong> Fully Unlocked &bull; Active
                </div>
            </div>

            <h3 style="color: #0f172a; font-size: 15px; margin-top: 24px; margin-bottom: 8px;">What You Can Do Now</h3>
            <ul style="font-size: 13px; color: #475569; padding-left: 20px; line-height: 1.7;">
                <li><strong>Apply for Open Cohorts:</strong> Enrol in Certified Brand Architect (CBA), Strategist (CBS), and Executive Masterclasses.</li>
                <li><strong>Submit Portfolio Deliverables:</strong> Upload your practical project decks for faculty assessment.</li>
                <li><strong>Digital Membership Card:</strong> Access your scannable digital credential card anytime.</li>
                <li><strong>Download Certificates:</strong> Access your high-resolution verified certificates with cryptographic QR validation.</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('member.dashboard') }}" style="display: inline-block; background-color: #0f172a; color: #fbbf24; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; font-size: 13px; border: 1px solid #d97706; margin-right: 8px; margin-bottom: 8px;">
                    Open Member Dashboard
                </a>
                @if ($member?->qr_code_token)
                    <a href="{{ route('membership.card', $member->qr_code_token) }}" style="display: inline-block; background-color: #f1f5f9; color: #0f172a; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 13px; border: 1px solid #cbd5e1; margin-bottom: 8px;">
                        View Digital Card
                    </a>
                @endif
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Warm regards,<br>
                <strong>Office of the Registrar &amp; Member Relations</strong><br>
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
