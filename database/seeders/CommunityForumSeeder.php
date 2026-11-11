<?php

namespace Database\Seeders;

use App\Models\ForumChannel;
use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommunityForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channelsData = [
            [
                'name' => 'Brand Strategy & Architecture',
                'slug' => 'brand-strategy-architecture',
                'description' => 'Positioning frameworks, brand equity valuation, consumer perception modeling, and corporate identity design.',
                'icon' => 'sparkles',
                'badge_color' => 'amber',
                'is_member_only' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Intellectual Property & Trademarks',
                'slug' => 'ip-trademarks-patents',
                'description' => 'CAC company name registration, trademark classification, patent filing best practices, and brand legal protection.',
                'icon' => 'shield-check',
                'badge_color' => 'emerald',
                'is_member_only' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Academic Research & JBSM Debates',
                'slug' => 'academic-research-jbsm',
                'description' => 'Methodology discussions, peer review feedback, manuscript inquiries, and empirical research in brand science.',
                'icon' => 'academic-cap',
                'badge_color' => 'indigo',
                'is_member_only' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Executive Masterminds & Leadership',
                'slug' => 'executive-masterminds',
                'description' => 'Confidential peer exchange, CMO advisory circles, board leadership, and elite practitioner networking. Reserved for verified members.',
                'icon' => 'lock-closed',
                'badge_color' => 'purple',
                'is_member_only' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'General Community Hub',
                'slug' => 'general-discussion',
                'description' => 'Introductions, platform announcements, networking coffee chats, and general marketing banter.',
                'icon' => 'chat-bubble-left-right',
                'badge_color' => 'sky',
                'is_member_only' => false,
                'sort_order' => 5,
            ],
        ];

        $channels = [];
        foreach ($channelsData as $data) {
            $channels[$data['slug']] = ForumChannel::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        $admin = User::where('role', 'admin')->first() ?? User::first();
        if (! $admin) {
            return;
        }

        // Sample Thread 1: Pinned Strategy Thread
        $thread1 = ForumThread::updateOrCreate(
            ['slug' => 'welcome-to-the-brands-academy-community-charter'],
            [
                'channel_id' => $channels['general-discussion']->id,
                'user_id' => $admin->id,
                'title' => 'Welcome to the Brands Academy Community: Forum Charter & Guidelines',
                'body' => "Welcome to the Brands Academy Nigeria Foundation peer discussion board!\n\nThis community exists to foster rigorous intellectual debate, professional mentorship, and actionable knowledge exchange between brand custodians, academic researchers, and enterprise founders across Africa.\n\n### Ground Rules:\n1. **Professional Civility**: Critique concepts and evidence, never colleagues.\n2. **Evidence-Based Insights**: When sharing strategies, reference case evidence or research backing whenever possible.\n3. **No Unsolicited Solicitation**: Keep discussions valuable and educational.\n\nIntroduce yourself below and share what brand domain you are currently tackling!",
                'is_pinned' => true,
                'is_locked' => false,
                'views_count' => 142,
                'last_activity_at' => now(),
            ]
        );

        // Sample Reply to Thread 1
        ForumReply::firstOrCreate(
            [
                'thread_id' => $thread1->id,
                'user_id' => $admin->id,
                'body' => 'Excited to inaugurate this digital assembly! Looking forward to hearing case studies on FMCG brand positioning in volatile exchange rate environments.',
            ]
        );

        // Sample Thread 2: IP & Trademark Q&A
        $thread2 = ForumThread::updateOrCreate(
            ['slug' => 'difference-between-trademark-class-35-and-class-42'],
            [
                'channel_id' => $channels['ip-trademarks-patents']->id,
                'user_id' => $admin->id,
                'title' => 'Distinguishing between Trademark Class 35 and Class 42 for Brand Consultancies',
                'body' => 'When filing for trademark protection at the Nigerian Registry for a branding agency that also delivers software-as-a-service audit tools, should we file concurrently under Class 35 (Advertising & Business Management) and Class 42 (Scientific & Technological Services)? What has been your practical experience with examiners?',
                'is_pinned' => false,
                'is_locked' => false,
                'views_count' => 88,
                'likes_count' => 6,
                'last_activity_at' => now(),
            ]
        );

        $reply2 = ForumReply::firstOrCreate(
            [
                'thread_id' => $thread2->id,
                'user_id' => $admin->id,
                'body' => 'Yes, multi-class filing is strictly advisable here. Class 35 protects your brand advisory, marketing audits, and strategic consultancy services. Class 42 shields the algorithmic audit engine, software platforms, and digital diagnostic portals. Failing to file Class 42 leaves your tech interface vulnerable to copycats even if your agency name is registered in Class 35.',
            ]
        );

        $reply2->update(['is_accepted_answer' => true, 'likes_count' => 4]);
    }
}
