<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MembershipPaymentGateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test unpaid verified member is blocked from dashboard and redirected to payment.
     */
    public function test_unpaid_verified_member_cannot_access_dashboard_and_is_redirected_to_payment(): void
    {
        $user = User::create([
            'name' => 'Unpaid Member',
            'email' => 'unpaid@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-UNPAID-01',
            'first_name' => 'Unpaid',
            'last_name' => 'Member',
            'email' => 'unpaid@example.com',
            'phone' => '+234 801 000 0001',
            'category' => 'professional',
            'state' => 'Kaduna',
            'payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/member/dashboard');
        $response->assertRedirect('/membership/payment');
        $response->assertSessionHas('warning');
    }

    /**
     * Test login redirects unpaid verified member to payment page.
     */
    public function test_login_redirects_unpaid_verified_member_to_payment_screen(): void
    {
        $user = User::create([
            'name' => 'Dues Pending',
            'email' => 'dues.pending@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-UNPAID-02',
            'first_name' => 'Dues',
            'last_name' => 'Pending',
            'email' => 'dues.pending@example.com',
            'phone' => '+234 801 000 0002',
            'category' => 'student',
            'state' => 'Kaduna',
            'payment_status' => 'pending',
        ]);

        $response = $this->post('/login', [
            'email' => 'dues.pending@example.com',
            'password' => 'secret1234',
        ]);

        $response->assertRedirect('/membership/payment');
        $response->assertSessionHas('warning');
    }

    /**
     * Test payment page displays correct category dues and bank details.
     */
    public function test_payment_page_renders_with_correct_tiered_category_dues(): void
    {
        $user = User::create([
            'name' => 'Corporate Leader',
            'email' => 'corp@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-CORP-01',
            'first_name' => 'Corporate',
            'last_name' => 'Leader',
            'email' => 'corp@example.com',
            'phone' => '+234 801 000 0003',
            'category' => 'corporate',
            'state' => 'Lagos',
            'payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/membership/payment');

        $response->assertStatus(200);
        $response->assertSee('₦75,000'); // Corporate tier amount
        $response->assertSee('Corporate Member');
        $response->assertSee('Zenith Bank Plc');
        $response->assertSee('1012345678');
    }

    /**
     * Test direct bank transfer receipt upload puts member status under review.
     */
    public function test_bank_transfer_receipt_upload_puts_member_under_review(): void
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'Transfer Payer',
            'email' => 'transfer@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-TRANSFER-01',
            'first_name' => 'Transfer',
            'last_name' => 'Payer',
            'email' => 'transfer@example.com',
            'phone' => '+234 801 000 0004',
            'category' => 'professional',
            'state' => 'Kaduna',
            'payment_status' => 'pending',
        ]);

        $file = UploadedFile::fake()->create('teller.pdf', 300, 'application/pdf');

        $response = $this->actingAs($user)->post('/membership/payment/bank-transfer', [
            'payment_proof' => $file,
            'sender_name' => 'Transfer Payer',
            'sender_bank' => 'Access Bank',
            'transfer_reference' => 'TXN-ACC-998877',
            'transfer_date' => now()->toDateString(),
        ]);

        $response->assertRedirect('/membership/payment');
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertEquals('under_review', $member->payment_status);
        $this->assertEquals('bank_transfer', $member->payment_method);
        $this->assertNotNull($member->payment_proof);

        // Dashboard is still protected while under review
        $dashResponse = $this->actingAs($user)->get('/member/dashboard');
        $dashResponse->assertRedirect('/membership/payment');
    }

    /**
     * Test admin can approve bank transfer payment and unlock member portal.
     */
    public function test_admin_can_approve_payment_and_unlock_portal(): void
    {
        $admin = User::create([
            'name' => 'Admin Officer',
            'email' => 'admin.officer@brandsacademy.org',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        $memberUser = User::create([
            'name' => 'Awaiting Member',
            'email' => 'awaiting@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $member = Member::create([
            'user_id' => $memberUser->id,
            'member_number' => 'BANF-MBR-APPROVE-01',
            'first_name' => 'Awaiting',
            'last_name' => 'Member',
            'email' => 'awaiting@example.com',
            'phone' => '+234 801 000 0005',
            'category' => 'student',
            'state' => 'Kaduna',
            'payment_status' => 'under_review',
        ]);

        $response = $this->actingAs($admin)->post("/admin/members/{$member->id}/payment-status", [
            'payment_status' => 'paid',
            'admin_notes' => 'Confirmed in Zenith bank statement.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertTrue($member->isPaid());
        $this->assertEquals('paid', $member->payment_status);

        // Now member has full dashboard access
        $dashResponse = $this->actingAs($memberUser)->get('/member/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Awaiting Member');
    }

    /**
     * Test sandbox Paystack initialization and activation unlocks dashboard.
     */
    public function test_paystack_sandbox_checkout_activates_membership_and_unlocks_dashboard(): void
    {
        $user = User::create([
            'name' => 'Card Payer',
            'email' => 'card@example.com',
            'password' => Hash::make('secret1234'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-CARD-01',
            'first_name' => 'Card',
            'last_name' => 'Payer',
            'email' => 'card@example.com',
            'phone' => '+234 801 000 0006',
            'category' => 'fellow',
            'state' => 'Abuja',
            'payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post('/membership/payment/initialize');

        $response->assertRedirect('/member/dashboard');
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertTrue($member->isPaid());
        $this->assertEquals('paid', $member->payment_status);
        $this->assertEquals(150000.00, (float) $member->paid_amount);

        // Confirmed direct dashboard access
        $dashResponse = $this->actingAs($user)->get('/member/dashboard');
        $dashResponse->assertStatus(200);
    }
}
