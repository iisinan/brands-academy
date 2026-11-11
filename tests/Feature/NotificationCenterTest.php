<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\ForumChannel;
use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\Member;
use App\Models\ServiceFiling;
use App\Models\User;
use App\Notifications\EcosystemActivityNotification;
use App\Services\LegalDeskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationCenterTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => UserRole::Member,
            'name' => 'Adewale Johnson',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $this->user->id,
            'member_number' => 'BANF-MBR-2026-NOTIF',
            'first_name' => 'Adewale',
            'last_name' => 'Johnson',
            'email' => $this->user->email,
            'phone' => '+234 802 111 2222',
            'category' => 'professional',
            'status' => 'active',
            'payment_status' => 'paid',
        ]);
    }

    public function test_guests_cannot_access_notifications(): void
    {
        $response = $this->get(route('notifications.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_notifications_list(): void
    {
        $this->user->notify(new EcosystemActivityNotification(
            title: 'CAC Filing Status Update',
            message: 'Your trademark application is under examiner review.',
            actionUrl: '/member/filings/BANF-FL-2026-TEST',
            category: 'filing',
            badgeText: 'BANF-FL-2026-TEST'
        ));

        $response = $this->actingAs($this->user)->get(route('notifications.index'));

        $response->assertOk();
        $response->assertSee('Notifications &amp; Activity Center', false);
        $response->assertSee('CAC Filing Status Update');
        $response->assertSee('Your trademark application is under examiner review.');
        $response->assertSee('BANF-FL-2026-TEST');
        $response->assertSee('1 unread');
    }

    public function test_filter_unread_notifications_only(): void
    {
        // 1 unread notification
        $this->user->notify(new EcosystemActivityNotification(
            title: 'Unread Notice',
            message: 'First unread message.',
            category: 'course'
        ));

        // 1 read notification
        $this->user->notify(new EcosystemActivityNotification(
            title: 'Already Read Notice',
            message: 'Old message.',
            category: 'system'
        ));

        $readNotification = $this->user->notifications()->where('data->title', 'Already Read Notice')->first();
        $readNotification->markAsRead();

        $response = $this->actingAs($this->user)->get(route('notifications.index', ['filter' => 'unread']));

        $response->assertOk();
        $response->assertSee('Unread Notice');
        $response->assertDontSee('Already Read Notice');
    }

    public function test_mark_single_notification_as_read_and_redirects(): void
    {
        $this->user->notify(new EcosystemActivityNotification(
            title: 'Certificate Ready',
            message: 'Your CPD certificate has been issued.',
            actionUrl: route('member.transcript'),
            category: 'certificate'
        ));

        $notification = $this->user->unreadNotifications()->first();
        $this->assertNotNull($notification);

        $response = $this->actingAs($this->user)->post(route('notifications.mark-read', $notification->id));

        $response->assertRedirect(route('member.transcript'));
        $this->assertEquals(0, $this->user->unreadNotifications()->count());
    }

    public function test_mark_all_notifications_as_read(): void
    {
        $this->user->notify(new EcosystemActivityNotification(
            title: 'Notice 1',
            message: 'First msg',
        ));
        $this->user->notify(new EcosystemActivityNotification(
            title: 'Notice 2',
            message: 'Second msg',
        ));

        $this->assertEquals(2, $this->user->unreadNotifications()->count());

        $response = $this->actingAs($this->user)->post(route('notifications.mark-all-read'));

        $response->assertRedirect();
        $this->assertEquals(0, $this->user->fresh()->unreadNotifications()->count());
    }

    public function test_unread_count_json_endpoint(): void
    {
        $this->user->notify(new EcosystemActivityNotification(
            title: 'Notice JSON',
            message: 'Fast poll count check',
        ));

        $response = $this->actingAs($this->user)->getJson(route('notifications.unread-count'));

        $response->assertOk();
        $response->assertJson([
            'unread_count' => 1,
        ]);
    }

    public function test_filing_status_transition_triggers_ecosystem_notification(): void
    {
        $filing = ServiceFiling::create([
            'tracking_code' => 'BANF-FL-2026-NOTIF1',
            'user_id' => $this->user->id,
            'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
            'proposed_name_1' => 'Apex Synergy Brands',
            'proposed_name_2' => 'Apex Synergy Concepts',
            'business_nature' => 'Brand strategy consulting and identity management.',
            'client_first_name' => 'Adewale',
            'client_last_name' => 'Johnson',
            'client_email' => $this->user->email,
            'client_phone' => '+234 802 333 4444',
            'business_address' => '12 Marina Road, Lagos',
            'total_fee' => 35000,
            'status' => ServiceFiling::STATUS_SUBMITTED,
        ]);

        $admin = User::factory()->create([
            'role' => UserRole::Admin,
            'name' => 'Barrister Aliyu',
        ]);

        $legalDeskService = app(LegalDeskService::class);
        $legalDeskService->transitionStatus(
            filing: $filing,
            newStatus: ServiceFiling::STATUS_LODGED_AT_REGISTRY,
            actor: $admin,
            remarks: 'Official filings lodged at CAC Registry Portal.',
            govtNumber: 'CAC/BN/2026/98765'
        );

        $notification = $this->user->unreadNotifications()->first();
        $this->assertNotNull($notification);
        $this->assertEquals('Filing Status: Lodged at Registry', $notification->data['title']);
        $this->assertStringContainsString('Official filings lodged at CAC Registry Portal.', $notification->data['message']);
        $this->assertEquals('BANF-FL-2026-NOTIF1', $notification->data['badge_text']);
        $this->assertEquals('filing', $notification->data['category']);
    }

    public function test_forum_reply_triggers_notification_to_thread_author(): void
    {
        $peer = User::factory()->create([
            'role' => UserRole::Member,
            'name' => 'Ngozi Eze',
            'email_verified_at' => now(),
        ]);

        $channel = ForumChannel::create([
            'name' => 'Brand Governance',
            'slug' => 'brand-governance-notif-test',
            'is_active' => true,
        ]);

        $thread = ForumThread::create([
            'channel_id' => $channel->id,
            'user_id' => $this->user->id,
            'title' => 'Protecting Corporate Identity Under CAMA 2020',
            'slug' => 'protecting-corporate-identity-notif-test',
            'body' => 'What are the enforcement mechanisms available?',
            'last_activity_at' => now(),
        ]);

        // Peer posts a reply
        $this->actingAs($peer)->post(route('forum.reply', [$channel->slug, $thread->slug]), [
            'body' => 'Under CAMA 2020 Part B, registered trustees can initiate passing-off actions directly.',
        ]);

        // Thread author should have 1 notification
        $notification = $this->user->unreadNotifications()->first();
        $this->assertNotNull($notification);
        $this->assertEquals('New Community Discussion Reply', $notification->data['title']);
        $this->assertStringContainsString('Ngozi Eze replied to your topic', $notification->data['message']);
        $this->assertEquals('forum', $notification->data['category']);

        // Author accepts the peer's answer
        $reply = ForumReply::where('thread_id', $thread->id)->first();
        $this->actingAs($this->user)->post(route('forum.accept', $reply->id));

        // Peer should now receive an Accepted Answer notification
        $peerNotification = $peer->unreadNotifications()->first();
        $this->assertNotNull($peerNotification);
        $this->assertEquals('Contribution Endorsed as Accepted Answer', $peerNotification->data['title']);
        $this->assertStringContainsString('was accepted by the author', $peerNotification->data['message']);
    }
}
