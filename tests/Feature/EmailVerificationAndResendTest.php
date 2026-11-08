<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Mail\ApplicationReceivedMail;
use App\Mail\ApplicationStatusUpdatedMail;
use App\Mail\InstitutionalInquiryMail;
use App\Mail\MemberWelcomeMail;
use App\Mail\PortfolioEvaluatedMail;
use App\Models\Member;
use App\Models\PortfolioSubmission;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopApplication;
use App\Notifications\VerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Transport\ResendTransport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationAndResendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the Resend transport driver is fully configured and resolvable.
     */
    public function test_resend_mail_driver_is_configured_and_resolves(): void
    {
        $this->assertEquals('resend', config('mail.mailers.resend.transport'));

        $mailer = Mail::mailer('resend');
        $this->assertInstanceOf(Mailer::class, $mailer);

        $transport = $mailer->getSymfonyTransport();
        $this->assertInstanceOf(ResendTransport::class, $transport);
    }

    /**
     * Test unverified member cannot access member dashboard (redirected to verification notice).
     */
    public function test_unverified_member_cannot_access_member_dashboard(): void
    {
        $user = User::create([
            'name' => 'Unverified Member',
            'email' => 'unverified@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => null,
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-TEST-001',
            'first_name' => 'Unverified',
            'last_name' => 'Member',
            'email' => 'unverified@example.com',
            'phone' => '+234 800 000 0001',
            'category' => 'student',
            'state' => 'Kaduna',
        ]);

        $response = $this->actingAs($user)->get('/member/dashboard');
        $response->assertRedirect('/email/verify');
    }

    /**
     * Test unverified member login redirects to verification notice screen.
     */
    public function test_unverified_member_login_redirects_to_verification_notice(): void
    {
        $user = User::create([
            'name' => 'Pending Verification',
            'email' => 'pending@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => null,
        ]);

        $response = $this->post('/login', [
            'email' => 'pending@example.com',
            'password' => 'secret1234',
        ]);

        $response->assertRedirect('/email/verify');
        $response->assertSessionHas('warning');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test registration dispatches verification email and redirects to verification notice.
     */
    public function test_registration_triggers_verification_notification_and_redirects_to_notice(): void
    {
        Notification::fake();

        $response = $this->post('/membership/register', [
            'first_name' => 'Chidi',
            'last_name' => 'Okafor',
            'email' => 'chidi.okafor@example.com',
            'phone' => '+234 803 999 8877',
            'category' => 'professional',
            'institution_or_company' => 'Brand Matrix',
            'designation' => 'Brand Director',
            'state' => 'Lagos',
            'country' => 'Nigeria',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/email/verify');
        $response->assertSessionHas('success');

        $user = User::where('email', 'chidi.okafor@example.com')->firstOrFail();
        $this->assertNull($user->email_verified_at);

        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    /**
     * Test clicking signed verification link marks email as verified and unlocks portal.
     */
    public function test_verification_url_verifies_email_and_grants_portal_access(): void
    {
        $user = User::create([
            'name' => 'Zainab Bello',
            'email' => 'zainab@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => null,
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-TEST-002',
            'first_name' => 'Zainab',
            'last_name' => 'Bello',
            'email' => 'zainab@example.com',
            'phone' => '+234 800 000 0002',
            'category' => 'professional',
            'state' => 'Kaduna',
            'payment_status' => 'paid',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/member/dashboard');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue($user->hasVerifiedEmail());

        // Now user has access to portal
        $dashboardResponse = $this->actingAs($user)->get('/member/dashboard');
        $dashboardResponse->assertStatus(200);
    }

    /**
     * Test unverified member can request a fresh verification email.
     */
    public function test_resend_verification_email_dispatches_notification(): void
    {
        Notification::fake();

        $user = User::create([
            'name' => 'Tunde Adeyemi',
            'email' => 'tunde@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->post('/email/verification-notification');

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    /**
     * Test verified member accessing verification notice is redirected to dashboard.
     */
    public function test_verified_member_accessing_verification_notice_is_redirected_to_dashboard(): void
    {
        $user = User::create([
            'name' => 'Already Verified',
            'email' => 'already@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/email/verify');
        $response->assertRedirect('/member/dashboard');
    }

    /**
     * Test workshop application submission dispatches confirmation receipt email.
     */
    public function test_workshop_application_submission_dispatches_confirmation_email(): void
    {
        Mail::fake();

        $workshop = Workshop::create([
            'title' => 'Brand Strategy Masterclass',
            'slug' => 'brand-strategy-masterclass',
            'track_type' => 'cbs',
            'description' => 'Comprehensive strategic brand masterclass.',
            'delivery_mode' => 'online',
            'fee_type' => 'free',
            'application_starts_at' => Carbon::now()->subDays(5),
            'application_deadline' => Carbon::now()->addDays(10),
            'starts_at' => Carbon::now()->addDays(15),
            'ends_at' => Carbon::now()->addDays(30),
            'status' => 'published',
        ]);

        $response = $this->post("/workshops/{$workshop->slug}/apply", [
            'applicant_name' => 'Emeka Obi',
            'applicant_email' => 'emeka.obi@example.com',
            'applicant_phone' => '+234 802 333 4455',
            'applicant_organization' => 'Apex Media',
            'statement_of_purpose' => 'I am eager to develop rigorous brand architecture methodologies for emerging consumer startups.',
        ]);

        $response->assertRedirect("/workshops/{$workshop->slug}");
        $response->assertSessionHas('success');

        Mail::assertSent(ApplicationReceivedMail::class, function ($mail) {
            return $mail->hasTo('emeka.obi@example.com') &&
                   $mail->application->applicant_name === 'Emeka Obi';
        });
    }

    /**
     * Test application status updates (waitlisted and rejected) dispatch update emails.
     */
    public function test_admin_status_update_waitlisted_and_rejected_dispatches_email(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Admissions Admin',
            'email' => 'admin.admissions@brandsacademy.org',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        $workshop = Workshop::create([
            'title' => 'CBA Flagship Track',
            'slug' => 'cba-flagship-track',
            'track_type' => 'cba',
            'description' => 'Flagship architect track.',
            'delivery_mode' => 'hybrid',
            'fee_type' => 'free',
            'application_starts_at' => Carbon::now()->subDays(10),
            'application_deadline' => Carbon::now()->addDays(5),
            'starts_at' => Carbon::now()->addDays(10),
            'ends_at' => Carbon::now()->addDays(40),
            'status' => 'published',
        ]);

        $application = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'applicant_name' => 'Bisi Alabi',
            'applicant_email' => 'bisi.alabi@example.com',
            'applicant_phone' => '+234 805 123 4567',
            'statement_of_purpose' => 'Passionate about brand strategy and architecture in West Africa.',
            'status' => 'pending',
        ]);

        // 1. Update to waitlisted
        $this->actingAs($admin)->post("/admin/applications/{$application->id}/status", [
            'status' => 'waitlisted',
            'admin_notes' => 'Placed on priority list pending capacity review.',
        ]);

        Mail::assertSent(ApplicationStatusUpdatedMail::class, function ($mail) {
            return $mail->hasTo('bisi.alabi@example.com') && $mail->status === 'waitlisted';
        });

        // 2. Update to rejected
        $this->actingAs($admin)->post("/admin/applications/{$application->id}/status", [
            'status' => 'rejected',
            'admin_notes' => 'Encouraged to re-apply next cycle.',
        ]);

        Mail::assertSent(ApplicationStatusUpdatedMail::class, function ($mail) {
            return $mail->hasTo('bisi.alabi@example.com') && $mail->status === 'rejected';
        });
    }

    /**
     * Test portfolio evaluation dispatches feedback email to student.
     */
    public function test_admin_portfolio_evaluation_dispatches_feedback_email(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Faculty Evaluator',
            'email' => 'evaluator@brandsacademy.org',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        $workshop = Workshop::create([
            'title' => 'Identity Systems Cohort',
            'slug' => 'identity-systems-cohort',
            'track_type' => 'cba',
            'description' => 'Brand identity systems.',
            'delivery_mode' => 'online',
            'fee_type' => 'free',
            'application_starts_at' => Carbon::now()->subDays(20),
            'application_deadline' => Carbon::now()->subDays(10),
            'starts_at' => Carbon::now()->subDays(5),
            'ends_at' => Carbon::now()->addDays(20),
            'status' => 'published',
        ]);

        $application = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'applicant_name' => 'Halima Musa',
            'applicant_email' => 'halima.musa@example.com',
            'applicant_phone' => '+234 809 888 7766',
            'statement_of_purpose' => 'Typography and identity systems for African FMCG brands.',
            'status' => 'accepted',
        ]);

        $submission = PortfolioSubmission::create([
            'workshop_application_id' => $application->id,
            'workshop_id' => $workshop->id,
            'title' => 'FMCG Brand Book & Style Guide',
            'description' => 'Comprehensive guidelines and deliverables for local consumer goods.',
            'deck_url' => 'https://drive.google.com/test-deck',
            'status' => 'submitted',
        ]);

        $this->actingAs($admin)->post("/admin/submissions/{$submission->id}/evaluate", [
            'status' => 'approved',
            'grade' => 'distinction',
            'mentor_feedback' => 'Exceptional visual hierarchy, brand positioning narrative, and typographic rigor.',
        ]);

        Mail::assertSent(PortfolioEvaluatedMail::class, function ($mail) {
            return $mail->hasTo('halima.musa@example.com') &&
                   $mail->submission->status === 'approved' &&
                   $mail->submission->grade === 'distinction';
        });
    }

    /**
     * Test corporate partnership inquiry dispatches client receipt and staff alert.
     */
    public function test_institutional_inquiry_dispatches_client_confirmation_and_internal_alert(): void
    {
        Mail::fake();

        $response = $this->post('/partnerships', [
            'organization_name' => 'Zenith Global Energy',
            'contact_person' => 'Engr. Dapo Alabi',
            'email' => 'dapo.alabi@zenithenergy.example',
            'phone' => '+234 803 555 4433',
            'organization_type' => 'corporate',
            'solution_interest' => 'staff_training',
            'estimated_cohort_size' => 25,
            'target_timeline' => 'Q1 2027',
            'message' => 'We are seeking bespoke brand identity and executive communications training for our senior leadership team.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Assert client confirmation sent
        Mail::assertSent(InstitutionalInquiryMail::class, function ($mail) {
            return $mail->hasTo('dapo.alabi@zenithenergy.example') && ! $mail->isInternalAlert;
        });

        // Assert internal notification sent
        Mail::assertSent(InstitutionalInquiryMail::class, function ($mail) {
            return $mail->isInternalAlert;
        });
    }

    /**
     * Test verification URL confirms email and dispatches MemberWelcomeMail.
     */
    public function test_verification_url_verifies_email_and_dispatches_welcome_mail(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Khadijah Sanusi',
            'email' => 'khadijah@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => null,
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-TEST-999',
            'first_name' => 'Khadijah',
            'last_name' => 'Sanusi',
            'email' => 'khadijah@example.com',
            'phone' => '+234 800 000 0999',
            'category' => 'corporate',
            'state' => 'Kaduna',
            'payment_status' => 'paid',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $this->actingAs($user)->get($verificationUrl);

        Mail::assertSent(MemberWelcomeMail::class, function ($mail) {
            return $mail->hasTo('khadijah@example.com') &&
                   $mail->user->email === 'khadijah@example.com';
        });
    }
}
