<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Member;
use App\Models\User;
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
}
