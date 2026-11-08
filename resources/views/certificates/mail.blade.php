<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Brands Academy Certificate of Achievement</title>
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
                Incorporated Trustee &bull; RC / IT No. 7344471
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 32px 30px; font-size: 15px; line-height: 1.6;">
            <p style="font-size: 17px; font-weight: bold; color: #0f172a; margin-top: 0;">
                Dear {{ $certificate->recipient_name }},
            </p>
            
            <p>
                Congratulations! On behalf of the Board of Trustees and faculty of <strong>Brands Academy Nigeria Foundation</strong>, we are proud to inform you that you have officially completed all requirements for:
            </p>

            <div style="background-color: #f1f5f9; border-left: 4px solid #d97706; padding: 16px 20px; margin: 20px 0; border-radius: 4px;">
                <div style="font-size: 13px; color: #64748b; text-transform: uppercase; font-weight: bold;">Accredited Programme</div>
                <div style="font-size: 18px; font-weight: bold; color: #0f172a; margin-top: 4px;">
                    {{ $certificate->course_title }}
                </div>
                <div style="font-size: 13px; color: #b45309; font-weight: 600; margin-top: 2px;">
                    {{ $certificate->track_tier }}
                </div>
                <div style="font-size: 12px; color: #475569; margin-top: 6px;">
                    <strong>Certificate Number:</strong> {{ $certificate->certificate_number }}
                </div>
            </div>

            <p>
                Your official, tamper-proof <strong>Certificate of Achievement</strong> is attached to this email as a high-resolution PDF document. You may download, print, or share it on your LinkedIn profile and professional credentials.
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('verify.certificate', $certificate->verification_token) }}" style="display: inline-block; background-color: #d97706; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                    Verify Certificate Online
                </a>
            </div>

            <p style="font-size: 13px; color: #64748b;">
                Employers and academic institutions can verify the authenticity of your credential at any time by scanning the QR code on your certificate or visiting:
                <br>
                <a href="{{ route('verify.certificate', $certificate->verification_token) }}" style="color: #b45309; word-break: break-all;">
                    {{ route('verify.certificate', $certificate->verification_token) }}
                </a>
            </p>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0;">

            <p style="margin-bottom: 0; font-size: 13px; color: #475569;">
                Warm regards,
                <br>
                <strong>Office of the Registrar & Board Secretariat</strong>
                <br>
                Brands Academy Nigeria Foundation
                <br>
                Kaduna, Nigeria
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8fafc; padding: 20px 30px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            Brands Academy Nigeria Foundation &bull; No. 27C, Ilorin Crescent, Ali-Akilu West, Marafa, Kaduna State, Nigeria.
        </div>

    </div>
</body>
</html>
