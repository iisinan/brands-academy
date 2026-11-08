<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email Address - Brands Academy Nigeria Foundation</title>
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
                Incorporated Trustee &bull; RC / IT No. 7344471 &bull; Membership &amp; Admissions Registry
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 30px; font-size: 15px; line-height: 1.6;">
            <p style="font-size: 17px; font-weight: bold; color: #0f172a; margin-top: 0;">
                Dear {{ $user->name }},
            </p>
            
            <p>
                Thank you for joining <strong>Brands Academy Nigeria Foundation</strong>. To safeguard your profile and ensure verified correspondence, please verify your email address to unlock full access to your <strong>Member Portal</strong>.
            </p>

            <div style="background-color: #f1f5f9; border-left: 4px solid #d97706; padding: 18px 20px; margin: 24px 0; border-radius: 6px;">
                <div style="font-size: 12px; color: #b45309; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">
                    Portal Access Requirement
                </div>
                <div style="font-size: 13px; color: #475569; margin-top: 6px; line-height: 1.5;">
                    <strong>Registered Email:</strong> {{ $user->email }}<br>
                    <strong>Status:</strong> Verification Pending &bull; Portal Access Locked
                </div>
            </div>

            <p style="font-size: 14px; color: #334155;">
                Click the button below to confirm your email and immediately activate access to your dashboard, workshop cohorts, and digital credentials:
            </p>

            <div style="text-align: center; margin: 32px 0;">
                <a href="{{ $url }}" style="display: inline-block; background-color: #0f172a; color: #fbbf24; text-decoration: none; padding: 14px 34px; border-radius: 8px; font-weight: bold; font-size: 14px; letter-spacing: 0.5px; border: 1px solid #d97706;">
                    Verify Email &amp; Unlock Portal Access
                </a>
            </div>

            <p style="font-size: 12px; color: #64748b; line-height: 1.5; background-color: #fef3c7; border: 1px solid #fde68a; padding: 12px 16px; border-radius: 6px;">
                <strong>Security Notice:</strong> This verification link will expire in 60 minutes. If you did not create an account with Brands Academy Nigeria Foundation, no further action is required.
            </p>

            <p style="font-size: 12px; color: #64748b; word-break: break-all; margin-top: 20px;">
                If you are having trouble clicking the button, copy and paste this URL into your web browser:<br>
                <a href="{{ $url }}" style="color: #b45309;">{{ $url }}</a>
            </p>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Warm regards,<br>
                <strong>Office of the Registrar &amp; Board Secretariat</strong><br>
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
