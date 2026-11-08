<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SmartRBACTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test member login automatically detects role and redirects to member dashboard.
     */
    public function test_member_login_automatically_detects_role_and_redirects_to_member_dashboard(): void
    {
        $member = User::create([
            'name' => 'Amina Member',
            'email' => 'amina@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $member->id,
            'member_number' => 'BANF-MBR-AMINA-01',
            'first_name' => 'Amina',
            'last_name' => 'Member',
            'email' => 'amina@example.com',
            'phone' => '+234 800 000 0001',
            'category' => 'professional',
            'state' => 'Kaduna',
            'payment_status' => 'paid',
        ]);

        $response = $this->post('/login', [
            'email' => 'amina@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/member/dashboard');
        $response->assertSessionHas('success');
        $this->assertAuthenticatedAs($member);
    }

    /**
     * Test admin login automatically detects role and redirects to admin dashboard.
     */
    public function test_admin_login_automatically_detects_role_and_redirects_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@brandsacademy.org',
            'password' => Hash::make('password123'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@brandsacademy.org',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $response->assertSessionHas('success');
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * Test member attempting to access admin route does not get stuck in 403 upon login.
     */
    public function test_member_attempting_to_access_admin_route_is_redirected_to_member_dashboard(): void
    {
        $user = User::create([
            'name' => 'John Member',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $user->id,
            'member_number' => 'BANF-MBR-JOHN-01',
            'first_name' => 'John',
            'last_name' => 'Member',
            'email' => 'john@example.com',
            'phone' => '+234 800 000 0002',
            'category' => 'professional',
            'state' => 'Kaduna',
            'payment_status' => 'paid',
        ]);

        // Unauthenticated visit to admin page stores intended url
        $this->get('/admin/dashboard')->assertRedirect('/login');

        // Log in as regular member
        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        // Smart RBAC clears invalid admin intended url and safely routes member to member dashboard
        $response->assertRedirect('/member/dashboard');
    }

    /**
     * Test authenticated member attempting to visit admin routes gets smart redirection with error.
     */
    public function test_authenticated_member_accessing_admin_route_is_redirected(): void
    {
        $member = User::create([
            'name' => 'Sara Member',
            'email' => 'sara@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::Member,
        ]);

        $response = $this->actingAs($member)->get('/admin/dashboard');

        $response->assertRedirect('/member/dashboard');
        $response->assertSessionHas('error', 'Unauthorized access. Administrator privileges required.');
    }

    /**
     * Test authenticated user visiting login page is redirected to their own role dashboard.
     */
    public function test_authenticated_users_are_redirected_to_their_respective_dashboards(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $this->actingAs($admin)->get('/login')->assertRedirect('/admin/dashboard');

        $member = User::create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Member,
        ]);

        $this->actingAs($member)->get('/login')->assertRedirect('/member/dashboard');
    }

    /**
     * Test real-time role detection endpoint detects roles accurately.
     */
    public function test_detect_role_endpoint_identifies_roles_correctly(): void
    {
        User::create([
            'name' => 'Admin Person',
            'email' => 'admintest@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        User::create([
            'name' => 'Member Person',
            'email' => 'membertest@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Member,
        ]);

        // Admin check
        $adminResp = $this->postJson('/login/detect-role', ['email' => 'admintest@brandsacademy.org']);
        $adminResp->assertStatus(200)
            ->assertJson([
                'detected' => true,
                'role' => 'admin',
                'is_admin' => true,
            ]);

        // Member check
        $memberResp = $this->postJson('/login/detect-role', ['email' => 'membertest@brandsacademy.org']);
        $memberResp->assertStatus(200)
            ->assertJson([
                'detected' => true,
                'role' => 'member',
                'is_admin' => false,
            ]);

        // Non-existent email check
        $notFoundResp = $this->postJson('/login/detect-role', ['email' => 'nonexistent@example.com']);
        $notFoundResp->assertStatus(200)
            ->assertJson([
                'detected' => false,
            ]);
    }

    /**
     * Test User model smart RBAC helpers and methods.
     */
    public function test_user_model_smart_rbac_helpers(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@example.com',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isMember());
        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($admin->hasRole(UserRole::Admin));
        $this->assertTrue($admin->hasRole(['admin', 'member']));
        $this->assertEquals('admin.dashboard', $admin->getDashboardRoute());
        $this->assertEquals('Administrator', $admin->role_label);

        $member = User::create([
            'name' => 'Ordinary Member',
            'email' => 'ordinary@example.com',
            'password' => Hash::make('secret'),
            'role' => 'member',
        ]);

        $this->assertFalse($member->isAdmin());
        $this->assertTrue($member->isMember());
        $this->assertTrue($member->hasRole('member'));
        $this->assertTrue($member->hasRole(UserRole::Member));
        $this->assertEquals('member.dashboard', $member->getDashboardRoute());
        $this->assertEquals('Foundation Member', $member->role_label);
    }

    /**
     * Test login view renders cleanly without confusing quick test account buttons.
     */
    public function test_login_page_renders_cleanly_without_account_toggle_buttons(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertDontSee('Quick Test Accounts');
        $response->assertDontSee('fillCredentials');
        $response->assertSee('Portal Sign In');
        $response->assertSee('Auto Role Detection');
    }

    /**
     * Test admin can view users list with role breakdown.
     */
    public function test_admin_can_view_users_list(): void
    {
        $admin = User::create([
            'name' => 'Managing Admin',
            'email' => 'managing@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('User Accounts');
        $response->assertSee('Managing Admin');
    }

    /**
     * Test admin can update another user's role.
     */
    public function test_admin_can_promote_user_to_admin(): void
    {
        $admin = User::create([
            'name' => 'Root Admin',
            'email' => 'root@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $user = User::create([
            'name' => 'Promoted Member',
            'email' => 'promoted@example.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Member,
        ]);

        $response = $this->actingAs($admin)->post("/admin/users/{$user->id}/role", [
            'role' => 'admin',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(UserRole::Admin, $user->fresh()->role);
    }

    /**
     * Test admin cannot demote their own account.
     */
    public function test_admin_cannot_demote_themselves(): void
    {
        $admin = User::create([
            'name' => 'Self Demoting Admin',
            'email' => 'self@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->actingAs($admin)->post("/admin/users/{$admin->id}/role", [
            'role' => 'member',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(UserRole::Admin, $admin->fresh()->role);
    }

    /**
     * Test member cannot access admin user management.
     */
    public function test_member_cannot_access_user_management(): void
    {
        $member = User::create([
            'name' => 'Normal Member',
            'email' => 'normal@example.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Member,
        ]);

        $response = $this->actingAs($member)->get('/admin/users');
        $response->assertRedirect('/member/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Test admin can access member dashboard in preview mode.
     */
    public function test_admin_can_access_member_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Preview Admin',
            'email' => 'preview@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/member/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Administrator View');
    }

    /**
     * Test admin can provision a new administrator user.
     */
    public function test_admin_can_provision_new_admin_user(): void
    {
        $admin = User::create([
            'name' => 'Managing Admin',
            'email' => 'managing@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Prof. Samaila Mande',
            'email' => 'mande@brandsacademy.org',
            'password' => 'securePassword123',
            'role' => 'admin',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'email' => 'mande@brandsacademy.org',
            'role' => 'admin',
        ]);
    }

    /**
     * Test admin can provision a new member user with auto-created Member profile.
     */
    public function test_admin_can_provision_new_member_user_with_profile(): void
    {
        $admin = User::create([
            'name' => 'Managing Admin',
            'email' => 'managing@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Khadijah Aliyu',
            'email' => 'khadijah@example.com',
            'password' => 'securePassword123',
            'role' => 'member',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'khadijah@example.com',
            'role' => 'member',
        ]);

        $this->assertDatabaseHas('members', [
            'email' => 'khadijah@example.com',
            'first_name' => 'Khadijah',
        ]);
    }

    /**
     * Test admin can delete a user account.
     */
    public function test_admin_can_delete_user_account(): void
    {
        $admin = User::create([
            'name' => 'Root Admin',
            'email' => 'root@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $userToDelete = User::create([
            'name' => 'Spam User',
            'email' => 'spam@example.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Member,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/users/{$userToDelete->id}");

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    /**
     * Test admin cannot delete their own active account.
     */
    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::create([
            'name' => 'Immortal Admin',
            'email' => 'immortal@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/users/{$admin->id}");

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /**
     * Test granular RBAC capabilities and Gate definitions.
     */
    public function test_granular_rbac_capabilities_and_gates(): void
    {
        $admin = User::create([
            'name' => 'Gate Admin',
            'email' => 'gateadmin@brandsacademy.org',
            'password' => Hash::make('secret'),
            'role' => UserRole::Admin,
        ]);

        $member = User::create([
            'name' => 'Gate Member',
            'email' => 'gatemember@example.com',
            'password' => Hash::make('secret'),
            'role' => UserRole::Member,
        ]);

        // Admin capabilities
        $this->assertTrue($admin->canPerform('view_admin_panel'));
        $this->assertTrue($admin->canPerform('manage_users'));
        $this->assertTrue($admin->canPerform('manage_workshops'));
        $this->assertTrue($admin->canPerform('evaluate_portfolios'));

        // Member capabilities
        $this->assertFalse($member->canPerform('manage_users'));
        $this->assertFalse($member->canPerform('manage_workshops'));
        $this->assertTrue($member->canPerform('view_member_portal'));
        $this->assertTrue($member->canPerform('apply_workshops'));
        $this->assertTrue($member->canPerform('submit_portfolio'));
    }
}
