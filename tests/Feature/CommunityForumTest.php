<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\ForumChannel;
use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityForumTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $memberUser;

    protected User $regularUser;

    protected Member $member;

    protected ForumChannel $publicChannel;

    protected ForumChannel $memberOnlyChannel;

    protected ForumThread $thread;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Admin user
        $this->admin = User::factory()->create([
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        // 2. Verified paid foundation member
        $this->memberUser = User::factory()->create([
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $this->member = Member::factory()->create([
            'user_id' => $this->memberUser->id,
            'payment_status' => 'paid',
            'status' => 'active',
        ]);

        // 3. Regular non-member user
        $this->regularUser = User::factory()->create([
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        // 4. Forum channels
        $this->publicChannel = ForumChannel::create([
            'name' => 'Brand Strategy & Positioning',
            'slug' => 'brand-strategy-positioning',
            'description' => 'Discussion regarding strategic brand architecture and market signaling.',
            'icon' => 'sparkles',
            'badge_color' => 'amber',
            'is_member_only' => false,
            'sort_order' => 1,
        ]);

        $this->memberOnlyChannel = ForumChannel::create([
            'name' => 'CMO Executive Circle',
            'slug' => 'cmo-executive-circle',
            'description' => 'Confidential advisory for certified brand practitioners.',
            'icon' => 'lock-closed',
            'badge_color' => 'purple',
            'is_member_only' => true,
            'sort_order' => 2,
        ]);

        // 5. Seed thread
        $this->thread = ForumThread::create([
            'channel_id' => $this->publicChannel->id,
            'user_id' => $this->memberUser->id,
            'title' => 'Framework for Measuring Brand Equity Multipliers in Fintech',
            'slug' => 'framework-measuring-brand-equity-fintech',
            'body' => 'What quantitative metrics do enterprise marketing leaders use when presenting brand equity multipliers to board audit committees?',
            'views_count' => 5,
            'last_activity_at' => now(),
        ]);
    }

    public function test_public_forum_index_renders_with_channels_and_threads(): void
    {
        $response = $this->get(route('forum.index'));
        $response->assertStatus(200);
        $response->assertSee('Brands Academy Community Board');
        $response->assertSee('Brand Strategy &amp; Positioning', false);
        $response->assertSee('Framework for Measuring Brand Equity Multipliers in Fintech');
    }

    public function test_channel_filter_renders_channel_specific_threads(): void
    {
        $response = $this->get(route('forum.channel', $this->publicChannel->slug));
        $response->assertStatus(200);
        $response->assertSee('Brand Strategy &amp; Positioning', false);
        $response->assertSee('Framework for Measuring Brand Equity Multipliers in Fintech');
    }

    public function test_thread_show_renders_and_increments_views(): void
    {
        $initialViews = $this->thread->views_count;

        $response = $this->get(route('forum.show', [
            $this->publicChannel->slug,
            $this->thread->slug,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Framework for Measuring Brand Equity Multipliers in Fintech');
        $response->assertSee('What quantitative metrics do enterprise marketing leaders use');

        $this->assertEquals($initialViews + 1, $this->thread->fresh()->views_count);
    }

    public function test_guest_cannot_create_thread(): void
    {
        $response = $this->get(route('forum.create'));
        $response->assertRedirect(route('login'));

        $responsePost = $this->post(route('forum.store'), [
            'channel_id' => $this->publicChannel->id,
            'title' => 'Unauthorized Guest Discussion',
            'body' => 'Should fail authentication middleware gate.',
        ]);
        $responsePost->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_thread(): void
    {
        $payload = [
            'channel_id' => $this->publicChannel->id,
            'title' => 'Emerging Trends in African Consumer Psychology',
            'body' => 'Analyzing generational loyalty shifts between Gen Z and millennial shoppers across urban Lagos and Abuja.',
        ];

        $response = $this->actingAs($this->regularUser)->post(route('forum.store'), $payload);

        $this->assertDatabaseHas('forum_threads', [
            'channel_id' => $this->publicChannel->id,
            'user_id' => $this->regularUser->id,
            'title' => 'Emerging Trends in African Consumer Psychology',
        ]);

        $created = ForumThread::where('title', 'Emerging Trends in African Consumer Psychology')->first();
        $this->assertNotNull($created);
        $response->assertRedirect(route('forum.show', [$this->publicChannel->slug, $created->slug]));
    }

    public function test_member_only_channel_enforces_restriction(): void
    {
        // 1. Regular user without approved membership tries to post to member-only channel
        $payload = [
            'channel_id' => $this->memberOnlyChannel->id,
            'title' => 'Unauthorized Post in CMO Circle',
            'body' => 'This attempt should be blocked and redirected back with an error.',
        ];

        $response = $this->actingAs($this->regularUser)->from(route('forum.create'))->post(route('forum.store'), $payload);
        $response->assertRedirect(route('forum.create'));
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('forum_threads', [
            'title' => 'Unauthorized Post in CMO Circle',
        ]);

        // 2. Verified member posts to member-only channel -> succeeds
        $validPayload = [
            'channel_id' => $this->memberOnlyChannel->id,
            'title' => 'CMO Confidential: Enterprise Rebranding Cost Allocation',
            'body' => 'Benchmarking average agency fees for cross-border FMCG rebranding.',
        ];

        $responseMember = $this->actingAs($this->memberUser)->post(route('forum.store'), $validPayload);
        $this->assertDatabaseHas('forum_threads', [
            'title' => 'CMO Confidential: Enterprise Rebranding Cost Allocation',
        ]);
    }

    public function test_user_can_reply_to_thread(): void
    {
        $payload = [
            'body' => 'We utilize an inter-temporal customer lifetime value (CLV) model combined with ISO 10668 brand valuation guidelines.',
        ];

        $response = $this->actingAs($this->regularUser)->post(
            route('forum.reply', [$this->publicChannel->slug, $this->thread->slug]),
            $payload
        );

        $response->assertRedirect(route('forum.show', [$this->publicChannel->slug, $this->thread->slug]));

        $this->assertDatabaseHas('forum_replies', [
            'thread_id' => $this->thread->id,
            'user_id' => $this->regularUser->id,
            'body' => $payload['body'],
        ]);

        $this->assertEquals(1, $this->thread->fresh()->replies_count);
    }

    public function test_user_cannot_reply_to_locked_thread(): void
    {
        $this->thread->update(['is_locked' => true]);

        $response = $this->actingAs($this->regularUser)->post(
            route('forum.reply', [$this->publicChannel->slug, $this->thread->slug]),
            ['body' => 'Trying to reply to a locked thread.']
        );

        $response->assertSessionHas('error');
        $this->assertEquals(0, $this->thread->fresh()->replies_count);
    }

    public function test_user_can_toggle_reaction_like(): void
    {
        // Like the thread
        $response1 = $this->actingAs($this->regularUser)->post(
            route('forum.react', ['thread', $this->thread->id])
        );

        $this->assertDatabaseHas('forum_reactions', [
            'user_id' => $this->regularUser->id,
            'reactable_type' => ForumThread::class,
            'reactable_id' => $this->thread->id,
        ]);
        $this->assertEquals(1, $this->thread->fresh()->likes_count);

        // Unlike
        $response2 = $this->actingAs($this->regularUser)->post(
            route('forum.react', ['thread', $this->thread->id])
        );

        $this->assertDatabaseMissing('forum_reactions', [
            'user_id' => $this->regularUser->id,
            'reactable_type' => ForumThread::class,
            'reactable_id' => $this->thread->id,
        ]);
        $this->assertEquals(0, $this->thread->fresh()->likes_count);
    }

    public function test_thread_author_can_mark_accepted_answer(): void
    {
        $reply = ForumReply::create([
            'thread_id' => $this->thread->id,
            'user_id' => $this->regularUser->id,
            'body' => 'Here is the precise valuation formula from ISO 10668.',
        ]);

        // Thread author (memberUser) marks accepted answer
        $response = $this->actingAs($this->memberUser)->post(route('forum.accept', $reply->id));
        $response->assertSessionHas('success');

        $this->assertTrue($reply->fresh()->is_accepted_answer);
    }

    public function test_non_author_non_admin_cannot_mark_accepted_answer(): void
    {
        $reply = ForumReply::create([
            'thread_id' => $this->thread->id,
            'user_id' => $this->memberUser->id,
            'body' => 'Some contribution here.',
        ]);

        // Regular user (not author, not admin) tries to mark accepted answer -> 403
        $response = $this->actingAs($this->regularUser)->post(route('forum.accept', $reply->id));
        $response->assertStatus(403);
    }

    public function test_admin_can_pin_lock_and_delete_threads_and_replies(): void
    {
        $reply = ForumReply::create([
            'thread_id' => $this->thread->id,
            'user_id' => $this->regularUser->id,
            'body' => 'Spam content to be purged by moderator.',
        ]);

        // 1. Admin toggles pin
        $this->actingAs($this->admin)->post(route('admin.forum.threads.pin', $this->thread->id));
        $this->assertTrue($this->thread->fresh()->is_pinned);

        // 2. Admin toggles lock
        $this->actingAs($this->admin)->post(route('admin.forum.threads.lock', $this->thread->id));
        $this->assertTrue($this->thread->fresh()->is_locked);

        // 3. Admin deletes reply
        $this->actingAs($this->admin)->delete(route('admin.forum.replies.destroy', $reply->id));
        $this->assertDatabaseMissing('forum_replies', ['id' => $reply->id]);

        // 4. Admin deletes thread
        $this->actingAs($this->admin)->delete(route('admin.forum.threads.destroy', $this->thread->id));
        $this->assertDatabaseMissing('forum_threads', ['id' => $this->thread->id]);
    }
}
