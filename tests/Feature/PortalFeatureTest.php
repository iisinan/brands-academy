<?php

namespace Tests\Feature;

use App\Mail\ApplicationAcceptedMail;
use App\Mail\CertificateIssuedMail;
use App\Models\Certificate;
use App\Models\InstitutionalInquiry;
use App\Models\Member;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopApplication;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PortalFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public pages render with HTTP 200.
     */
    public function test_public_pages_render_successfully(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/about')->assertStatus(200);
        $this->get('/faculty')->assertStatus(200);
        $this->get('/partnerships')->assertStatus(200);
        $this->get('/workshops')->assertStatus(200);
        $this->get('/membership/register')->assertStatus(200);
        $this->get('/verify')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
    }

    /**
     * Test ongoing membership registration (Pillar 1: 24/7).
     */
    public function test_ongoing_membership_registration_creates_account_and_member_id(): void
    {
        $response = $this->post('/membership/register', [
            'first_name' => 'Fatima',
            'last_name' => 'Suleiman',
            'email' => 'fatima.s@example.com',
            'phone' => '+234 809 111 2233',
            'category' => 'professional',
            'institution_or_company' => 'Brand Vanguard Studio',
            'designation' => 'Senior Visual Designer',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'bio' => 'Interested in typography and brand strategy.',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $response->assertRedirect('/email/verify');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'fatima.s@example.com',
            'role' => 'member',
        ]);

        $this->assertDatabaseHas('members', [
            'email' => 'fatima.s@example.com',
            'first_name' => 'Fatima',
            'last_name' => 'Suleiman',
            'category' => 'professional',
        ]);

        $member = Member::where('email', 'fatima.s@example.com')->first();
        $this->assertStringStartsWith('BANF-MBR-', $member->member_number);
    }

    /**
     * Test ongoing membership registration with merged full name field.
     */
    public function test_ongoing_membership_registration_with_merged_full_name(): void
    {
        $response = $this->post('/membership/register', [
            'name' => 'Umar Suleiman',
            'email' => 'umar.s@example.com',
            'phone' => '+234 809 333 4455',
            'category' => 'student',
            'institution_or_company' => 'Ahmadu Bello University',
            'designation' => 'Undergraduate Student',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $response->assertRedirect('/email/verify');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'Umar Suleiman',
            'email' => 'umar.s@example.com',
            'role' => 'member',
        ]);

        $this->assertDatabaseHas('members', [
            'email' => 'umar.s@example.com',
            'first_name' => 'Umar',
            'last_name' => 'Suleiman',
            'category' => 'student',
        ]);
    }

    /**
     * Test application window logic (Pillar 2: Open vs Closed).
     */
    public function test_can_apply_to_workshop_during_active_application_window(): void
    {
        $workshop = Workshop::create([
            'title' => 'CBA Spring Cohort',
            'slug' => 'cba-spring-cohort',
            'track_type' => 'cba',
            'description' => 'Comprehensive branding foundation cohort.',
            'delivery_mode' => 'hybrid',
            'fee_type' => 'free',
            'fee_amount' => 0,
            'application_starts_at' => Carbon::now()->subDays(2),
            'application_deadline' => Carbon::now()->addDays(10),
            'starts_at' => Carbon::now()->addDays(15),
            'ends_at' => Carbon::now()->addDays(45),
            'status' => 'published',
        ]);

        $this->assertTrue($workshop->isOpenForApplications());

        $response = $this->post("/workshops/{$workshop->slug}/apply", [
            'applicant_name' => 'Nasir Bello',
            'applicant_email' => 'nasir@example.com',
            'applicant_phone' => '+234 805 444 3322',
            'applicant_organization' => 'Apex Agency',
            'statement_of_purpose' => 'I am looking to deepen my foundational branding knowledge.',
            'portfolio_link' => 'https://example.com/portfolio',
        ]);

        $response->assertRedirect("/workshops/{$workshop->slug}");
        $this->assertDatabaseHas('workshop_applications', [
            'applicant_email' => 'nasir@example.com',
            'workshop_id' => $workshop->id,
            'status' => 'pending',
        ]);
    }

    /**
     * Test that application is rejected if the window has closed.
     */
    public function test_application_is_rejected_when_application_window_is_closed(): void
    {
        $workshop = Workshop::create([
            'title' => 'Closed Cohort',
            'slug' => 'closed-cohort',
            'track_type' => 'cbs',
            'description' => 'A past cohort whose deadline elapsed.',
            'delivery_mode' => 'online',
            'fee_type' => 'paid',
            'fee_amount' => 25000,
            'application_starts_at' => Carbon::now()->subDays(20),
            'application_deadline' => Carbon::now()->subDays(1),
            'starts_at' => Carbon::now()->addDays(5),
            'ends_at' => Carbon::now()->addDays(30),
            'status' => 'published',
        ]);

        $this->assertFalse($workshop->isOpenForApplications());

        $response = $this->from("/workshops/{$workshop->slug}")->post("/workshops/{$workshop->slug}/apply", [
            'applicant_name' => 'Late Applicant',
            'applicant_email' => 'late@example.com',
            'applicant_phone' => '+234 801 222 3344',
            'statement_of_purpose' => 'Applying after deadline has passed.',
        ]);

        $response->assertRedirect("/workshops/{$workshop->slug}");
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('workshop_applications', [
            'applicant_email' => 'late@example.com',
            'workshop_id' => $workshop->id,
        ]);
    }

    /**
     * Test certificate verification and PDF download.
     */
    public function test_public_credential_verification_and_pdf_generation(): void
    {
        $workshop = Workshop::create([
            'title' => 'Certified Brand Executive (CBE)',
            'slug' => 'cbe-cohort-1',
            'track_type' => 'cbe',
            'description' => 'Executive level accreditation.',
            'delivery_mode' => 'in_person',
            'fee_type' => 'paid',
            'fee_amount' => 50000,
            'application_starts_at' => Carbon::now()->subDays(30),
            'application_deadline' => Carbon::now()->subDays(10),
            'starts_at' => Carbon::now()->subDays(5),
            'ends_at' => Carbon::now()->addDays(5),
            'status' => 'published',
        ]);

        $cert = Certificate::create([
            'certificate_number' => 'BANF-CERT-2024-TEST1',
            'verification_token' => 'token-test-verify-12345',
            'workshop_id' => $workshop->id,
            'recipient_name' => 'Zainab Ahmed',
            'recipient_email' => 'zainab@example.com',
            'course_title' => $workshop->title,
            'track_tier' => 'Tier 3: Certified Brand Executive (CBE)',
            'issued_at' => now()->toDateString(),
        ]);

        // Verify page loads with recipient name
        $verifyResponse = $this->get('/verify?q='.$cert->certificate_number);
        $verifyResponse->assertStatus(200);
        $verifyResponse->assertSee('Zainab Ahmed');
        $verifyResponse->assertSee('Authentic Certificate Verified');

        // Test PDF preview
        $previewResponse = $this->get("/certificates/{$cert->verification_token}/preview");
        $previewResponse->assertStatus(200);
        $previewResponse->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * Test admin can issue certificate and trigger automated email.
     */
    public function test_admin_can_issue_certificate_and_dispatch_email(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'superadmin@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $workshop = Workshop::create([
            'title' => 'Brand Strategy Bootcamp',
            'slug' => 'brand-strategy-bootcamp',
            'track_type' => 'cba',
            'description' => 'Intensive bootcamp.',
            'delivery_mode' => 'hybrid',
            'fee_type' => 'free',
            'application_starts_at' => Carbon::now()->subDays(10),
            'application_deadline' => Carbon::now()->subDays(2),
            'starts_at' => Carbon::now()->subDay(),
            'ends_at' => Carbon::now()->addDays(10),
            'status' => 'published',
        ]);

        $application = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'applicant_name' => 'Halima Bello',
            'applicant_email' => 'halima@example.com',
            'applicant_phone' => '+234 802 333 4455',
            'statement_of_purpose' => 'Ready to advance.',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($admin)->post("/admin/applications/{$application->id}/issue-certificate");

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('certificates', [
            'workshop_application_id' => $application->id,
            'recipient_email' => 'halima@example.com',
            'email_status' => 'sent',
        ]);

        Mail::assertSent(CertificateIssuedMail::class, function (CertificateIssuedMail $mail) {
            return $mail->hasTo('halima@example.com') && ! empty($mail->pdfData);
        });
    }

    /**
     * Test application status change to accepted sends offer letter email.
     */
    public function test_accepting_application_sends_offer_letter_email(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admissions@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $workshop = Workshop::create([
            'title' => 'CBS Masterclass',
            'slug' => 'cbs-masterclass',
            'track_type' => 'cbs',
            'description' => 'Strategist cohort.',
            'delivery_mode' => 'online',
            'fee_type' => 'paid',
            'application_starts_at' => Carbon::now()->subDays(5),
            'application_deadline' => Carbon::now()->addDays(5),
            'starts_at' => Carbon::now()->addDays(10),
            'ends_at' => Carbon::now()->addDays(40),
            'status' => 'published',
        ]);

        $app = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'applicant_name' => 'Kareem Musa',
            'applicant_email' => 'kareem@example.com',
            'applicant_phone' => '+234 803 777 8899',
            'statement_of_purpose' => 'Ready to learn brand strategy.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/admin/applications/{$app->id}/status", [
            'status' => 'accepted',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('accepted', $app->fresh()->status);

        Mail::assertSent(ApplicationAcceptedMail::class, function ($mail) {
            return $mail->hasTo('kareem@example.com');
        });
    }

    /**
     * Test student portfolio project submission.
     */
    public function test_member_can_submit_portfolio_deliverables(): void
    {
        $user = User::create([
            'name' => 'Amina Student',
            'email' => 'amina.student@example.com',
            'password' => Hash::make('secret'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-2024-TEST99',
            'first_name' => 'Amina',
            'last_name' => 'Student',
            'email' => 'amina.student@example.com',
            'phone' => '+234 801 111 2233',
            'category' => 'student',
            'state' => 'Kaduna',
        ]);

        $workshop = Workshop::create([
            'title' => 'CBA Spring Track',
            'slug' => 'cba-spring-track',
            'track_type' => 'cba',
            'description' => 'Course description.',
            'delivery_mode' => 'hybrid',
            'fee_type' => 'free',
            'application_starts_at' => Carbon::now()->subDays(15),
            'application_deadline' => Carbon::now()->subDays(5),
            'starts_at' => Carbon::now()->subDays(2),
            'ends_at' => Carbon::now()->addDays(30),
            'status' => 'published',
        ]);

        $app = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'member_id' => $member->id,
            'user_id' => $user->id,
            'applicant_name' => 'Amina Student',
            'applicant_email' => 'amina.student@example.com',
            'applicant_phone' => '+234 801 111 2233',
            'statement_of_purpose' => 'Passionate about design.',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($user)->post("/member/applications/{$app->id}/submit-portfolio", [
            'title' => 'SolarGrid Brand Identity System',
            'description' => 'Complete positioning, tone of voice guidelines and brand book for renewable startup.',
            'deck_url' => 'https://behance.net/gallery/999/SolarGrid',
            'deliverables' => "Brand Positioning\nVisual Identity\nSocial Templates",
        ]);

        $response->assertRedirect('/member/dashboard');
        $this->assertDatabaseHas('portfolio_submissions', [
            'workshop_application_id' => $app->id,
            'title' => 'SolarGrid Brand Identity System',
            'status' => 'submitted',
        ]);
    }

    /**
     * Test admin bulk certificate issuance for a cohort.
     */
    public function test_admin_can_bulk_issue_certificates_for_cohort(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Dean of Academics',
            'email' => 'dean@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $workshop = Workshop::create([
            'title' => 'Brand Associate Cohort 1',
            'slug' => 'brand-associate-cohort-1',
            'track_type' => 'cba',
            'description' => 'Course description.',
            'delivery_mode' => 'online',
            'fee_type' => 'free',
            'application_starts_at' => Carbon::now()->subDays(20),
            'application_deadline' => Carbon::now()->subDays(10),
            'starts_at' => Carbon::now()->subDays(8),
            'ends_at' => Carbon::now()->subDay(),
            'status' => 'published',
        ]);

        $app1 = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'applicant_name' => 'Student One',
            'applicant_email' => 'student1@example.com',
            'applicant_phone' => '+234 801 111 0001',
            'statement_of_purpose' => 'Learning goals.',
            'status' => 'accepted',
        ]);

        $app2 = WorkshopApplication::create([
            'workshop_id' => $workshop->id,
            'applicant_name' => 'Student Two',
            'applicant_email' => 'student2@example.com',
            'applicant_phone' => '+234 801 111 0002',
            'statement_of_purpose' => 'Learning goals.',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($admin)->post("/admin/workshops/{$workshop->id}/bulk-issue-certificates");

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('certificates', [
            'workshop_application_id' => $app1->id,
            'recipient_email' => 'student1@example.com',
        ]);

        $this->assertDatabaseHas('certificates', [
            'workshop_application_id' => $app2->id,
            'recipient_email' => 'student2@example.com',
        ]);

        Mail::assertSent(CertificateIssuedMail::class, 2);
    }

    /**
     * Test admin CSV exports for members and certificates.
     */
    public function test_admin_can_export_csv_reports(): void
    {
        $admin = User::create([
            'name' => 'Auditor Admin',
            'email' => 'auditor@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $membersExport = $this->actingAs($admin)->get('/admin/members/export');
        $membersExport->assertStatus(200);
        $membersExport->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $certExport = $this->actingAs($admin)->get('/admin/certificates/export');
        $certExport->assertStatus(200);
        $certExport->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /**
     * Test institutional inquiry submission and admin management.
     */
    public function test_institutional_inquiry_submission_and_admin_workflow(): void
    {
        $response = $this->post('/partnerships', [
            'organization_name' => 'Ahmadu Bello University Brand Lab',
            'contact_person' => 'Dr. Ibrahim Aliyu',
            'email' => 'dr.aliyu@abu.edu.ng',
            'phone' => '+234 803 999 8877',
            'organization_type' => 'higher_education',
            'solution_interest' => 'curriculum_licensing',
            'estimated_cohort_size' => 120,
            'target_timeline' => 'Q3 Academic Session',
            'message' => 'We wish to license the CBA brand identity curriculum for undergraduate mass communications students.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('institutional_inquiries', [
            'organization_name' => 'Ahmadu Bello University Brand Lab',
            'email' => 'dr.aliyu@abu.edu.ng',
            'organization_type' => 'higher_education',
            'status' => 'new',
        ]);

        $admin = User::create([
            'name' => 'Partnership Director',
            'email' => 'director@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        // Admin can list inquiries
        $this->actingAs($admin)->get('/admin/inquiries')->assertStatus(200);

        $inquiry = InstitutionalInquiry::where('email', 'dr.aliyu@abu.edu.ng')->first();

        // Admin updates status
        $updateResp = $this->actingAs($admin)->post("/admin/inquiries/{$inquiry->id}/status", [
            'status' => 'in_discussion',
            'admin_notes' => 'Introductory meeting scheduled with Dean of Arts.',
        ]);

        $updateResp->assertSessionHas('success');

        $this->assertDatabaseHas('institutional_inquiries', [
            'id' => $inquiry->id,
            'status' => 'in_discussion',
            'admin_notes' => 'Introductory meeting scheduled with Dean of Arts.',
        ]);
    }

    /**
     * Test admin can view edit page and update workshop cohort.
     */
    public function test_admin_can_edit_and_update_workshop(): void
    {
        $admin = User::create([
            'name' => 'Workshop Dean',
            'email' => 'dean@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $workshop = Workshop::create([
            'title' => 'Original Cohort Title',
            'slug' => 'original-cohort-title',
            'track_type' => 'cba',
            'description' => 'Original description.',
            'delivery_mode' => 'online',
            'fee_type' => 'free',
            'fee_amount' => 0,
            'application_starts_at' => Carbon::now()->subDays(5),
            'application_deadline' => Carbon::now()->addDays(5),
            'starts_at' => Carbon::now()->addDays(10),
            'ends_at' => Carbon::now()->addDays(30),
            'status' => 'published',
        ]);

        $this->actingAs($admin)->get("/admin/workshops/{$workshop->id}/edit")->assertStatus(200);

        $response = $this->actingAs($admin)->put("/admin/workshops/{$workshop->id}", [
            'title' => 'Updated CBA Masterclass Title',
            'track_type' => 'cba',
            'tagline' => 'Updated tagline',
            'description' => 'Expanded curriculum and mentoring hours.',
            'curriculum_topics' => "Topic One\nTopic Two",
            'delivery_mode' => 'hybrid',
            'fee_type' => 'subsidized',
            'fee_amount' => 12000,
            'capacity' => 50,
            'application_starts_at' => Carbon::now()->subDays(5)->toDateTimeString(),
            'application_deadline' => Carbon::now()->addDays(20)->toDateTimeString(), // extended deadline
            'starts_at' => Carbon::now()->addDays(25)->toDateTimeString(),
            'ends_at' => Carbon::now()->addDays(60)->toDateTimeString(),
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/workshops');

        $this->assertDatabaseHas('workshops', [
            'id' => $workshop->id,
            'title' => 'Updated CBA Masterclass Title',
            'fee_amount' => 12000,
            'capacity' => 50,
        ]);
    }

    /**
     * Test password reset request page and reset link submission.
     */
    public function test_password_reset_flow_and_request_link(): void
    {
        $user = User::create([
            'name' => 'Password Test User',
            'email' => 'resetuser@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'member',
        ]);

        $this->get('/forgot-password')->assertStatus(200);

        $response = $this->post('/forgot-password', [
            'email' => 'resetuser@example.com',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'resetuser@example.com',
        ]);
    }

    /**
     * Test admin can resend certificate email.
     */
    public function test_admin_can_resend_certificate_email(): void
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Dispatch Admin',
            'email' => 'dispatch@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $workshop = Workshop::create([
            'title' => 'Certified Brand Associate Cohort',
            'slug' => 'cba-cohort-test-cert',
            'track_type' => 'cba',
            'description' => 'Test workshop description.',
            'delivery_mode' => 'online',
            'fee_type' => 'free',
            'application_starts_at' => Carbon::now()->subDays(10),
            'application_deadline' => Carbon::now()->subDays(5),
            'starts_at' => Carbon::now()->subDays(3),
            'ends_at' => Carbon::now()->subDay(),
            'status' => 'published',
        ]);

        $cert = Certificate::create([
            'certificate_number' => 'BANF-CERT-TEST-999',
            'verification_token' => 'test-token-uuid-999',
            'workshop_id' => $workshop->id,
            'recipient_name' => 'Zainab Ahmed',
            'recipient_email' => 'zainab@example.com',
            'course_title' => 'Certified Brand Associate',
            'track_tier' => 'Tier 1: CBA',
            'issued_at' => now()->toDateString(),
            'email_status' => 'sent',
        ]);

        $response = $this->actingAs($admin)->post("/admin/certificates/{$cert->verification_token}/email");

        $response->assertSessionHas('success');
        Mail::assertSent(CertificateIssuedMail::class);
    }
}
