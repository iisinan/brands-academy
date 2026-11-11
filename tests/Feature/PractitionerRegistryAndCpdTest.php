<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Certificate;
use App\Models\Conference;
use App\Models\ConferenceDelegate;
use App\Models\ConferenceTicket;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PractitionerRegistryAndCpdTest extends TestCase
{
    use RefreshDatabase;

    protected User $activeUser;

    protected Member $activeMember;

    protected User $unpaidUser;

    protected Member $unpaidMember;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Active, paid practitioner
        $this->activeUser = User::factory()->create([
            'role' => UserRole::Member,
            'name' => 'Dr. Amina Kabir',
            'email_verified_at' => now(),
        ]);

        $this->activeMember = Member::create([
            'user_id' => $this->activeUser->id,
            'member_number' => 'BANF-MBR-2026-TEST1',
            'first_name' => 'Amina',
            'last_name' => 'Kabir',
            'email' => $this->activeUser->email,
            'phone' => '+234 803 111 2222',
            'category' => 'fellow',
            'institution_or_company' => 'Apex Brand Advisory',
            'designation' => 'Principal Partner',
            'state' => 'Lagos',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'paid',
            'bio' => 'Senior fellow with 20+ years in corporate identity governance.',
        ]);

        // 2. Unpaid / pending member
        $this->unpaidUser = User::factory()->create([
            'role' => UserRole::Member,
            'name' => 'Pending Applicant',
            'email_verified_at' => now(),
        ]);

        $this->unpaidMember = Member::create([
            'user_id' => $this->unpaidUser->id,
            'member_number' => null,
            'first_name' => 'Pending',
            'last_name' => 'Applicant',
            'email' => $this->unpaidUser->email,
            'phone' => '+234 809 999 8888',
            'category' => 'professional',
            'status' => 'active',
            'payment_status' => 'pending',
        ]);
    }

    public function test_public_registry_displays_active_paid_practitioners_only(): void
    {
        $response = $this->get(route('registry.index'));

        $response->assertOk();
        $response->assertSee('Amina Kabir');
        $response->assertSee('BANF-MBR-2026-TEST1');
        $response->assertSee('Apex Brand Advisory');
        $response->assertSee('Fellow of Brands Academy (FBA)');

        // Unpaid applicant must NOT be listed
        $response->assertDontSee('Pending Applicant');
    }

    public function test_registry_search_and_filters(): void
    {
        // Second active member in Abuja
        $user2 = User::factory()->create(['email_verified_at' => now()]);
        Member::create([
            'user_id' => $user2->id,
            'member_number' => 'BANF-MBR-2026-TEST2',
            'first_name' => 'Emeka',
            'last_name' => 'Okonkwo',
            'email' => $user2->email,
            'phone' => '+234 802 333 4444',
            'category' => 'professional',
            'institution_or_company' => 'Zeta Communications',
            'designation' => 'Brand Manager',
            'state' => 'Abuja',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'paid',
        ]);

        // 1. Search keyword "Apex"
        $searchRes = $this->get(route('registry.index', ['q' => 'Apex']));
        $searchRes->assertOk();
        $searchRes->assertSee('Amina Kabir');
        $searchRes->assertDontSee('Emeka Okonkwo');

        // 2. Filter category "professional"
        $filterCategoryRes = $this->get(route('registry.index', ['category' => 'professional']));
        $filterCategoryRes->assertOk();
        $filterCategoryRes->assertSee('Emeka Okonkwo');
        $filterCategoryRes->assertDontSee('Amina Kabir');

        // 3. Filter state "Abuja"
        $filterStateRes = $this->get(route('registry.index', ['state' => 'Abuja']));
        $filterStateRes->assertOk();
        $filterStateRes->assertSee('Emeka Okonkwo');
        $filterStateRes->assertDontSee('Amina Kabir');
    }

    public function test_practitioner_dossier_profile_page_displays_credentials_and_cpd(): void
    {
        // Award certificate
        Certificate::create([
            'certificate_number' => 'BANF-CERT-2026-ABC1',
            'verification_token' => 'token-test-12345',
            'recipient_name' => $this->activeMember->full_name,
            'recipient_email' => $this->activeMember->email,
            'course_title' => 'Executive Brand Architecture Certificate',
            'member_id' => $this->activeMember->id,
            'issued_at' => now(),
        ]);

        // Conference accreditation
        $conf = Conference::create([
            'title' => '2026 Nigeria Brand Summit',
            'slug' => '2026-nigeria-brand-summit-reg-test',
            'venue' => 'Transcorp Hilton Abuja',
            'starts_at' => Carbon::now()->addMonth(),
            'ends_at' => Carbon::now()->addMonth()->addDays(2),
            'is_active' => true,
        ]);

        $ticket = ConferenceTicket::create([
            'conference_id' => $conf->id,
            'name' => 'Member Delegate Pass',
            'regular_price' => 50000,
            'member_price' => 37500,
            'quantity_available' => 100,
        ]);

        ConferenceDelegate::create([
            'conference_id' => $conf->id,
            'ticket_id' => $ticket->id,
            'user_id' => $this->activeUser->id,
            'first_name' => 'Amina',
            'last_name' => 'Kabir',
            'email' => $this->activeUser->email,
            'badge_code' => 'BANF-CONF-TEST-99',
            'checked_in' => true,
        ]);

        $response = $this->get(route('registry.show', $this->activeMember->member_number));

        $response->assertOk();
        $response->assertSee('Amina Kabir');
        $response->assertSee('BANF-MBR-2026-TEST1');
        $response->assertSee('Executive Brand Architecture Certificate');
        $response->assertSee('BANF-CONF-TEST-99');
        $response->assertSee('Statutory Verification');
    }

    public function test_member_cpd_transcript_requires_paid_membership(): void
    {
        // 1. Guest redirected
        $guestRes = $this->get(route('member.transcript'));
        $guestRes->assertRedirect(route('login'));

        // 2. Unpaid member redirected
        $unpaidRes = $this->actingAs($this->unpaidUser)->get(route('member.transcript'));
        $unpaidRes->assertRedirect(route('membership.payment'));

        // 3. Paid member accesses transcript
        $course = Course::create([
            'title' => 'Brand DNA & Strategy Frameworks',
            'slug' => 'brand-dna-strategy-frameworks-cpd-test',
            'track' => 'Brand Strategy',
            'delivery_mode' => 'self_paced',
            'fee_type' => 'free',
            'is_published' => true,
        ]);

        CourseEnrollment::create([
            'user_id' => $this->activeUser->id,
            'course_id' => $course->id,
            'status' => 'completed',
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);

        $paidRes = $this->actingAs($this->activeUser)->get(route('member.transcript'));
        $paidRes->assertOk();
        $paidRes->assertSee('Official CPD Learning Record & Transcript');
        $paidRes->assertSee('Brand DNA & Strategy Frameworks');
        $paidRes->assertSee('10.0');
        $paidRes->assertSeeText('CPD Units');
    }

    public function test_statutory_fee_calculator_page_renders_with_nice_classes(): void
    {
        $response = $this->get(route('services.calculator'));

        $response->assertOk();
        $response->assertSee('Statutory CAC, Trademark & IP Fee Calculator');
        $response->assertSee('CAC Business Name');
        $response->assertSee('CAC Private Ltd Company');
        $response->assertSee('Trademark Registration');
        $response->assertSee('Trademark Nice Class Explorer');
        $response->assertSee('Class 35');
        $response->assertSee('Advertising, Retail & Business Advisory');
        $response->assertSee('Class 9');
        $response->assertSee('Software, Mobile Apps & Hardware');
    }

    public function test_member_can_download_cpd_transcript_pdf(): void
    {
        // 1. Guest redirected
        $guestRes = $this->get(route('member.transcript.download'));
        $guestRes->assertRedirect(route('login'));

        // 2. Unpaid member redirected
        $unpaidRes = $this->actingAs($this->unpaidUser)->get(route('member.transcript.download'));
        $unpaidRes->assertRedirect(route('membership.payment'));

        // 3. Paid member can download PDF
        $response = $this->actingAs($this->activeUser)->get(route('member.transcript.download'));

        $response->assertOk();
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment', (string) $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('BANF-CPD-Transcript', (string) $response->headers->get('Content-Disposition'));
    }
}
