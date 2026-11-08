<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class MemberApplicationAndDiscountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test authenticated paid member visiting membership register redirects directly to dashboard.
     */
    public function test_authenticated_paid_member_visiting_membership_register_bypasses_to_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-2026-99999',
            'first_name' => 'Fatima',
            'last_name' => 'Bello',
            'email' => $user->email,
            'phone' => '+234 803 111 2233',
            'category' => 'professional',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'paid',
            'qr_code_token' => (string) Str::uuid(),
            'joined_at' => now()->toDateString(),
        ]);

        $response = $this->actingAs($user)->get(route('membership.register'));

        $response->assertRedirect(route('member.dashboard'));
        $response->assertSessionHas('info');
    }

    /**
     * Test authenticated unpaid member visiting membership register redirects directly to payment.
     */
    public function test_authenticated_unpaid_member_visiting_membership_register_bypasses_to_payment(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => null,
            'first_name' => 'Aliyu',
            'last_name' => 'Garba',
            'email' => $user->email,
            'phone' => '+234 803 444 5566',
            'category' => 'student',
            'state' => 'Kano',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'pending',
            'qr_code_token' => (string) Str::uuid(),
            'joined_at' => now()->toDateString(),
        ]);

        $response = $this->actingAs($user)->get(route('membership.register'));

        $response->assertRedirect(route('membership.payment'));
        $response->assertSessionHas('info');
    }

    /**
     * Test existing registered user submitting registration form again is recognized and redirected to payment.
     */
    public function test_existing_registered_user_submitting_registration_form_is_recognized(): void
    {
        $existingUser = User::factory()->create([
            'email' => 'existing.applicant@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $existingUser->id,
            'member_number' => null,
            'first_name' => 'Existing',
            'last_name' => 'Applicant',
            'email' => $existingUser->email,
            'phone' => '+234 801 234 5678',
            'category' => 'professional',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'pending',
            'qr_code_token' => (string) Str::uuid(),
            'joined_at' => now()->toDateString(),
        ]);

        $response = $this->post(route('membership.store'), [
            'name' => 'Existing Applicant',
            'first_name' => 'Existing',
            'last_name' => 'Applicant',
            'email' => 'existing.applicant@example.com',
            'phone' => '+234 801 234 5678',
            'category' => 'professional',
            'state' => 'Kaduna',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
        ]);

        $response->assertRedirect(route('membership.payment'));
        $response->assertSessionHas('info');
    }

    /**
     * Test workshop model calculates 25% member tuition discount and savings accurately.
     */
    public function test_workshop_model_calculates_twenty_five_percent_member_discount_correctly(): void
    {
        $workshop = Workshop::create([
            'title' => 'Advanced Brand Strategy Masterclass',
            'slug' => 'advanced-brand-strategy-test',
            'track_type' => 'cbs',
            'description' => 'Comprehensive syllabus and curriculum.',
            'fee_type' => 'paid',
            'fee_amount' => 40000.00,
            'capacity' => 25,
            'application_starts_at' => now()->subDay(),
            'application_deadline' => now()->addWeeks(2),
            'starts_at' => now()->addWeeks(3),
            'ends_at' => now()->addWeeks(8),
            'status' => 'published',
        ]);

        $this->assertEquals(25, $workshop->member_discount_percentage);
        $this->assertEquals(30000.00, $workshop->member_fee_amount); // 40,000 - 25% = 30,000
        $this->assertEquals(10000.00, $workshop->member_discount_savings); // 10,000 saved
    }

    /**
     * Test authenticated member applying for open cohort has details auto-populated and receives discount notice.
     */
    public function test_authenticated_member_applying_for_workshop_has_details_auto_populated(): void
    {
        $user = User::factory()->create([
            'name' => 'Zainab Danladi',
            'email' => 'zainab.d@example.com',
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-2026-77777',
            'first_name' => 'Zainab',
            'last_name' => 'Danladi',
            'email' => $user->email,
            'phone' => '+234 809 999 8888',
            'category' => 'professional',
            'institution_or_company' => 'Northern Design Works',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'paid',
            'qr_code_token' => (string) Str::uuid(),
            'joined_at' => now()->toDateString(),
        ]);

        $workshop = Workshop::create([
            'title' => 'Brand Executive Masterclass',
            'slug' => 'brand-executive-masterclass-test',
            'track_type' => 'cbe',
            'description' => 'Comprehensive executive syllabus.',
            'fee_type' => 'paid',
            'fee_amount' => 60000.00,
            'capacity' => 20,
            'application_starts_at' => now()->subDay(),
            'application_deadline' => now()->addWeeks(2),
            'starts_at' => now()->addWeeks(3),
            'ends_at' => now()->addWeeks(8),
            'status' => 'published',
        ]);

        // Member submits with only statement_of_purpose (system auto-populates personal details)
        $response = $this->actingAs($user)->post(route('workshops.apply', $workshop->slug), [
            'statement_of_purpose' => 'I am eager to expand my leadership acumen across enterprise branding and creative direction.',
        ]);

        $response->assertRedirect(route('workshops.show', $workshop->slug));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('workshop_applications', [
            'workshop_id' => $workshop->id,
            'member_id' => $member->id,
            'user_id' => $user->id,
            'applicant_email' => 'zainab.d@example.com',
            'applicant_name' => 'Zainab Danladi',
            'applicant_phone' => '+234 809 999 8888',
        ]);
    }

    /**
     * Test workshop details page displays 25% member discount and pre-filled recognition card for logged-in member.
     */
    public function test_workshop_show_page_displays_member_discount_and_recognition_card(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-2026-12345',
            'first_name' => 'Ibrahim',
            'last_name' => 'Musa',
            'email' => $user->email,
            'phone' => '+234 803 777 6655',
            'category' => 'professional',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'paid',
            'qr_code_token' => (string) Str::uuid(),
            'joined_at' => now()->toDateString(),
        ]);

        $workshop = Workshop::create([
            'title' => 'Brand Associate Cohort 2026',
            'slug' => 'brand-associate-cohort-2026',
            'track_type' => 'cba',
            'description' => 'Comprehensive associate training.',
            'fee_type' => 'paid',
            'fee_amount' => 20000.00,
            'capacity' => 40,
            'application_starts_at' => now()->subDay(),
            'application_deadline' => now()->addWeeks(2),
            'starts_at' => now()->addWeeks(3),
            'ends_at' => now()->addWeeks(8),
            'status' => 'published',
        ]);

        $response = $this->actingAs($user)->get(route('workshops.show', $workshop->slug));

        $response->assertOk();
        $response->assertSee('25% Member Discount');
        $response->assertSee('NGN 15,000'); // 20,000 - 25%
        $response->assertSee('BANF-MBR-2026-12345');
        $response->assertSee('Account Recognized');
        $response->assertSee('The system already has your details on file');
    }
}
