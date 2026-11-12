<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\FilingDocument;
use App\Models\Member;
use App\Models\ServiceFiling;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LegalServiceFilingsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $memberUser;

    protected Member $member;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->admin = User::factory()->create([
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        $this->memberUser = User::factory()->create([
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $this->member = Member::factory()->create([
            'user_id' => $this->memberUser->id,
            'payment_status' => 'paid',
            'status' => 'active',
        ]);
    }

    public function test_public_legal_services_showcase_renders(): void
    {
        $response = $this->get(route('services.index'));
        $response->assertStatus(200);
        $response->assertSee('Brand Intellectual Property');
        $response->assertSee('CAC Business Name');
        $response->assertSee('Trademark Protection');
        $response->assertSee('25% legal fee discount');
    }

    public function test_filing_wizard_page_renders_with_tracks(): void
    {
        $response = $this->get(route('services.wizard', ['type' => 'cac_business_name']));
        $response->assertStatus(200);
        $response->assertSee('Client Filing Intake Desk');
        $response->assertSee('Select Filing Track');
        $response->assertSee('Option 1 (Primary Choice)');
    }

    public function test_filing_wizard_renders_with_member_sidebar_when_authenticated_member(): void
    {
        $user = User::create([
            'name' => 'Sani Salihu',
            'email' => 'sani.filing@example.com',
            'password' => bcrypt('secret1234'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-2026-FILING',
            'first_name' => 'Sani',
            'last_name' => 'Salihu',
            'email' => 'sani.filing@example.com',
            'phone' => '+234 803 000 9988',
            'category' => 'professional',
            'institution_or_company' => 'Bayero University Kano',
            'designation' => 'Research Fellow',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'paid',
            'joined_at' => now()->toDateString(),
            'qr_code_token' => 'sani-filing-qr-token',
        ]);

        $response = $this->actingAs($user)->get(route('services.wizard', ['type' => 'cac_business_name']));
        $response->assertStatus(200);
        $response->assertSee('Member Portal Active');
        $response->assertSee('Client Filing Intake Desk');
        $response->assertSee('CAC &amp; IP Filings', false);
    }

    public function test_client_can_submit_intake_wizard_with_documents(): void
    {
        $ninFile = UploadedFile::fake()->create('nin_slip.pdf', 500, 'application/pdf');
        $photoFile = UploadedFile::fake()->image('passport.jpg', 300, 300);

        $payload = [
            'filing_type' => 'cac_business_name',
            'proposed_name_1' => 'Sterling Brand Logistics',
            'proposed_name_2' => 'Sterling Brand Advisory',
            'proposed_name_3' => 'Sterling Brand Ventures',
            'business_nature' => 'Brand management, intellectual property strategy, and corporate communication.',
            'industry_category' => 'Consulting',
            'business_address' => 'Plot 10, Admiralty Way, Lekki Phase 1, Lagos',
            'headquarters_state' => 'Lagos',
            'client_first_name' => 'Emeka',
            'client_last_name' => 'Nnamdi',
            'client_email' => 'emeka@sterling.ng',
            'client_phone' => '+234 803 999 8877',
            'client_nin' => '29182736451',
            'nin_slip' => $ninFile,
            'passport_photo' => $photoFile,
        ];

        $response = $this->post(route('services.store'), $payload);

        $this->assertDatabaseHas('service_filings', [
            'proposed_name_1' => 'Sterling Brand Logistics',
            'client_email' => 'emeka@sterling.ng',
            'status' => ServiceFiling::STATUS_PAYMENT_PENDING,
        ]);

        $filing = ServiceFiling::where('proposed_name_1', 'Sterling Brand Logistics')->first();
        $this->assertNotNull($filing);
        $this->assertCount(2, $filing->documents);

        $response->assertRedirect(route('services.payment', $filing->tracking_code));
    }

    public function test_payment_simulation_transitions_filing_to_submitted(): void
    {
        $filing = ServiceFiling::create([
            'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
            'proposed_name_1' => 'Zenith Brand Studio',
            'client_first_name' => 'Aisha',
            'client_last_name' => 'Bello',
            'client_email' => 'aisha@zenith.ng',
            'client_phone' => '+234 809 111 2222',
            'business_nature' => 'Creative branding',
            'business_address' => 'Wuse 2, Abuja',
            'headquarters_state' => 'Abuja',
            'status' => ServiceFiling::STATUS_PAYMENT_PENDING,
            'total_fee' => 35000.00,
            'fee_paid' => 0.00,
        ]);

        $response = $this->post(route('services.pay', $filing->tracking_code));

        $filing->refresh();
        $this->assertEquals(ServiceFiling::STATUS_SUBMITTED, $filing->status);
        $this->assertEquals(35000.00, (float) $filing->fee_paid);
        $this->assertNotNull($filing->submitted_at);
        $response->assertRedirect(route('services.track', ['code' => $filing->tracking_code]));
    }

    public function test_public_tracking_portal_displays_case(): void
    {
        $filing = ServiceFiling::create([
            'tracking_code' => 'BANF-CAC-2026-TEST01',
            'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
            'proposed_name_1' => 'Quantum Brand Matrix',
            'client_first_name' => 'Tunde',
            'client_last_name' => 'Bakare',
            'client_email' => 'tunde@matrix.ng',
            'client_phone' => '+234 801 222 3333',
            'business_nature' => 'Corporate Identity',
            'business_address' => 'Ikeja, Lagos',
            'headquarters_state' => 'Lagos',
            'status' => ServiceFiling::STATUS_SEARCH_IN_PROGRESS,
            'total_fee' => 35000.00,
        ]);

        $response = $this->get(route('services.track', ['code' => 'BANF-CAC-2026-TEST01']));
        $response->assertStatus(200);
        $response->assertSee('BANF-CAC-2026-TEST01');
        $response->assertSee('Quantum Brand Matrix');
        $response->assertSee('Name Search In Progress');
    }

    public function test_member_filings_dashboard_renders(): void
    {
        $filing = ServiceFiling::create([
            'user_id' => $this->memberUser->id,
            'member_id' => $this->member->id,
            'tracking_code' => 'BANF-CAC-2026-MEMB01',
            'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
            'proposed_name_1' => 'Omni Brand Solutions',
            'client_first_name' => $this->member->first_name,
            'client_last_name' => $this->member->last_name,
            'client_email' => $this->memberUser->email,
            'client_phone' => '+234 805 111 2222',
            'business_nature' => 'Marketing',
            'business_address' => 'Victoria Island, Lagos',
            'headquarters_state' => 'Lagos',
            'status' => ServiceFiling::STATUS_SUBMITTED,
            'total_fee' => 26250.00,
            'member_discount' => 8750.00,
        ]);

        $response = $this->actingAs($this->memberUser)->get(route('member.filings.index'));
        $response->assertStatus(200);
        $response->assertSee('Omni Brand Solutions');
        $response->assertSee('BANF-CAC-2026-MEMB01');
    }

    public function test_member_can_resubmit_queried_document(): void
    {
        $filing = ServiceFiling::create([
            'user_id' => $this->memberUser->id,
            'member_id' => $this->member->id,
            'tracking_code' => 'BANF-TM-2026-QUERY1',
            'filing_type' => ServiceFiling::TYPE_TRADEMARK,
            'proposed_name_1' => 'Nova Device Mark',
            'client_first_name' => $this->member->first_name,
            'client_last_name' => $this->member->last_name,
            'client_email' => $this->memberUser->email,
            'client_phone' => '+234 805 111 2222',
            'business_nature' => 'Trademarking in Class 35',
            'business_address' => 'Abuja',
            'headquarters_state' => 'Abuja',
            'status' => ServiceFiling::STATUS_QUERIED,
            'client_query_message' => 'Please provide clear vector logo',
            'total_fee' => 63750.00,
        ]);

        $logoFile = UploadedFile::fake()->image('clear_logo.png', 500, 500);

        $response = $this->actingAs($this->memberUser)->post(
            route('member.filings.upload', $filing->tracking_code),
            [
                'document_type' => FilingDocument::TYPE_TRADEMARK_LOGO,
                'document_file' => $logoFile,
                'client_comment' => 'Uploaded high-res PNG as requested.',
            ]
        );

        $filing->refresh();
        $this->assertEquals(ServiceFiling::STATUS_LODGED_AT_REGISTRY, $filing->status);
        $this->assertCount(1, $filing->documents);
        $response->assertRedirect(route('member.filings.show', $filing->tracking_code));
    }

    public function test_admin_can_manage_filing_status(): void
    {
        $filing = ServiceFiling::create([
            'tracking_code' => 'BANF-CAC-2026-ADM01',
            'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
            'proposed_name_1' => 'Vortex Brand Group',
            'client_first_name' => 'Femi',
            'client_last_name' => 'Adekunle',
            'client_email' => 'femi@vortex.ng',
            'client_phone' => '+234 808 123 4567',
            'business_nature' => 'Branding',
            'business_address' => 'Lagos',
            'headquarters_state' => 'Lagos',
            'status' => ServiceFiling::STATUS_SUBMITTED,
            'total_fee' => 35000.00,
        ]);

        // Admin index
        $indexResponse = $this->actingAs($this->admin)->get(route('admin.filings'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Vortex Brand Group');

        // Admin updates status to lodged_at_registry
        $updateResponse = $this->actingAs($this->admin)->post(
            route('admin.filings.status', $filing->id),
            [
                'status' => ServiceFiling::STATUS_LODGED_AT_REGISTRY,
                'government_filing_number' => 'AVAIL-2026-9921',
                'remarks' => 'Availability approved. Lodged formal BN documentation with CAC.',
            ]
        );

        $filing->refresh();
        $this->assertEquals(ServiceFiling::STATUS_LODGED_AT_REGISTRY, $filing->status);
        $this->assertEquals('AVAIL-2026-9921', $filing->government_filing_number);
        $updateResponse->assertRedirect(route('admin.filings.show', $filing->id));
    }

    public function test_admin_can_upload_official_certificate(): void
    {
        $filing = ServiceFiling::create([
            'tracking_code' => 'BANF-CAC-2026-CERT01',
            'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
            'proposed_name_1' => 'Global Brand Syndicate',
            'client_first_name' => 'Grace',
            'client_last_name' => 'Danladi',
            'client_email' => 'grace@syndicate.ng',
            'client_phone' => '+234 809 333 4444',
            'business_nature' => 'Publishing',
            'business_address' => 'Kaduna',
            'headquarters_state' => 'Kaduna',
            'status' => ServiceFiling::STATUS_LODGED_AT_REGISTRY,
            'total_fee' => 35000.00,
        ]);

        $certPdf = UploadedFile::fake()->create('cac_certificate.pdf', 800, 'application/pdf');

        $response = $this->actingAs($this->admin)->post(
            route('admin.filings.certificate', $filing->id),
            [
                'government_filing_number' => 'BN 3892102',
                'official_certificate' => $certPdf,
                'remarks' => 'CAC Certificate officially issued and verified.',
            ]
        );

        $filing->refresh();
        $this->assertEquals(ServiceFiling::STATUS_APPROVED, $filing->status);
        $this->assertEquals('BN 3892102', $filing->government_filing_number);
        $this->assertNotNull($filing->official_certificate_path);
        $this->assertNotNull($filing->approved_at);
        $response->assertRedirect(route('admin.filings.show', $filing->id));
    }

    public function test_admin_can_export_filings_csv(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.filings.export'));
        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type') ?? '', 'text/csv'));
    }
}
