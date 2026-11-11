<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\CallForPaper;
use App\Models\Conference;
use App\Models\ConferenceDelegate;
use App\Models\ConferenceTicket;
use App\Models\JournalArticle;
use App\Models\JournalIssue;
use App\Models\JournalVolume;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConferenceAndJournalTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $memberUser;

    protected Member $member;

    protected Conference $conference;

    protected ConferenceTicket $ticket;

    protected JournalVolume $volume;

    protected JournalIssue $issue;

    protected JournalArticle $article;

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

        $this->conference = Conference::create([
            'title' => '2026 Nigeria Brand Leadership Summit',
            'slug' => 'nigeria-brand-leadership-summit-2026',
            'theme' => 'Brand Valuation & African Markets',
            'year' => 2026,
            'venue' => 'Transcorp Hilton, Abuja',
            'starts_at' => Carbon::now()->addMonth(),
            'ends_at' => Carbon::now()->addMonth()->addDays(2),
            'description' => 'The premier gathering of brand strategists and policymakers.',
            'is_active' => true,
            'cfp_open' => true,
        ]);

        $this->ticket = ConferenceTicket::create([
            'conference_id' => $this->conference->id,
            'name' => 'General Delegate Pass',
            'regular_price' => 35000.00,
            'member_price' => 26250.00,
            'quantity_available' => 100,
            'quantity_sold' => 0,
            'benefits' => ['Full summit access', 'Plenary luncheons'],
        ]);

        $this->volume = JournalVolume::create([
            'volume_number' => 1,
            'year' => 2026,
            'title' => 'Volume 1 (2026)',
            'is_published' => true,
        ]);

        $this->issue = JournalIssue::create([
            'volume_id' => $this->volume->id,
            'issue_number' => 1,
            'title' => 'Inaugural Issue on African Brand Equity',
            'published_date' => now()->toDateString(),
            'is_published' => true,
        ]);

        $this->article = JournalArticle::create([
            'issue_id' => $this->issue->id,
            'submitted_by_user_id' => $this->admin->id,
            'title' => 'Strategic Brand Equity Dynamics in Emerging Markets',
            'slug' => 'strategic-brand-equity-dynamics-in-emerging-markets',
            'abstract' => 'This academic paper investigates market signaling and brand equity multipliers across consumer enterprises.',
            'keywords' => 'Brand Equity, Market Signaling, Africa',
            'doi' => '10.5281/jbsm.2026.01.01',
            'page_start' => 1,
            'page_end' => 20,
            'submission_status' => JournalArticle::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);
    }

    public function test_public_conferences_index_renders(): void
    {
        $response = $this->get(route('conferences.index'));
        $response->assertStatus(200);
        $response->assertSee('Brand Leadership Summits');
        $response->assertSee('2026 Nigeria Brand Leadership Summit');
    }

    public function test_conference_show_page_renders_with_tickets(): void
    {
        $response = $this->get(route('conferences.show', $this->conference->slug));
        $response->assertStatus(200);
        $response->assertSee('2026 Nigeria Brand Leadership Summit');
        $response->assertSee('General Delegate Pass');
        $response->assertSee('Reserve Delegate Pass');
    }

    public function test_delegate_registration_with_member_discount(): void
    {
        $payload = [
            'ticket_id' => $this->ticket->id,
            'first_name' => 'Chioma',
            'last_name' => 'Okeke',
            'email' => 'chioma@example.ng',
            'organization' => 'Zenith Brand Advisory',
            'designation' => 'Principal Consultant',
        ];

        // Authenticated as member: gets 25% discount (26,250 instead of 35,000)
        $response = $this->actingAs($this->memberUser)->post(
            route('conferences.register', $this->conference->slug),
            $payload
        );

        $this->assertDatabaseHas('conference_delegates', [
            'conference_id' => $this->conference->id,
            'first_name' => 'Chioma',
            'last_name' => 'Okeke',
            'email' => 'chioma@example.ng',
            'amount_paid' => 26250.00,
        ]);

        $delegate = ConferenceDelegate::where('email', 'chioma@example.ng')->first();
        $this->assertNotNull($delegate);
        $this->assertNotNull($delegate->badge_code);
        $response->assertRedirect(route('conferences.badge', $delegate->badge_code));
    }

    public function test_digital_badge_page_renders(): void
    {
        $delegate = ConferenceDelegate::create([
            'conference_id' => $this->conference->id,
            'ticket_id' => $this->ticket->id,
            'first_name' => 'Tunde',
            'last_name' => 'Bakare',
            'email' => 'tunde@example.ng',
            'badge_code' => 'BANF-CONF-2026-TEST01',
            'amount_paid' => 35000.00,
        ]);

        $response = $this->get(route('conferences.badge', 'BANF-CONF-2026-TEST01'));
        $response->assertStatus(200);
        $response->assertSee('Tunde Bakare');
        $response->assertSee('BANF-CONF-2026-TEST01');
        $response->assertSee('Digital Delegate Summit Pass');
    }

    public function test_call_for_papers_submission(): void
    {
        $pdf = UploadedFile::fake()->create('abstract_paper.pdf', 500, 'application/pdf');

        $payload = [
            'title' => 'Empirical Analysis of Trademark Protection in ECOWAS',
            'author_name' => 'Dr. Amina Yusuf',
            'author_email' => 'amina@abu.edu.ng',
            'author_institution' => 'Ahmadu Bello University',
            'abstract_text' => 'This paper investigates the statutory protection of brand trademarks and market surveillance mechanisms in West Africa across a 5-year longitudinal sample.',
            'keywords' => 'Trademarks, ECOWAS, IP Law, Africa',
            'manuscript_pdf' => $pdf,
        ];

        $response = $this->post(route('conferences.cfp.submit', $this->conference->slug), $payload);

        $this->assertDatabaseHas('call_for_papers', [
            'conference_id' => $this->conference->id,
            'title' => 'Empirical Analysis of Trademark Protection in ECOWAS',
            'author_name' => 'Dr. Amina Yusuf',
            'review_status' => CallForPaper::STATUS_SUBMITTED,
        ]);

        $response->assertRedirect(route('conferences.show', $this->conference->slug));
    }

    public function test_public_journal_index_renders_with_articles(): void
    {
        $response = $this->get(route('journal.index'));
        $response->assertStatus(200);
        $response->assertSee('Journal of Brand Strategy & Management');
        $response->assertSee('Strategic Brand Equity Dynamics in Emerging Markets');
        $response->assertSee('Vol. 1(1)');
    }

    public function test_journal_article_reader_and_citations(): void
    {
        $response = $this->get(route('journal.show', $this->article->slug));
        $response->assertStatus(200);
        $response->assertSee('Strategic Brand Equity Dynamics in Emerging Markets');
        $response->assertSee('doi:10.5281/jbsm.2026.01.01');
        $response->assertSee('Cite this Article');

        $this->article->refresh();
        $this->assertEquals(1, $this->article->views_count);
    }

    public function test_author_can_submit_journal_manuscript(): void
    {
        $pdf = UploadedFile::fake()->create('manuscript_full.pdf', 1000, 'application/pdf');

        $payload = [
            'title' => 'Corporate Reputation Signals and Foreign Direct Investment',
            'abstract' => 'This structured study analyzes corporate brand signaling on cross-border FDI allocations in Nigerian consumer manufacturing sectors between 2018 and 2025.',
            'keywords' => 'FDI, Corporate Reputation, Market Signals, Africa',
            'primary_author_name' => 'Prof. Samuel Okonkwo',
            'primary_author_email' => 'samuel@apexbrand.ng',
            'primary_author_affiliation' => 'Lagos Business School',
            'primary_author_orcid' => '0000-0001-2345-6789',
            'manuscript_pdf' => $pdf,
        ];

        $response = $this->post(route('journal.store'), $payload);

        $this->assertDatabaseHas('journal_articles', [
            'title' => 'Corporate Reputation Signals and Foreign Direct Investment',
            'submission_status' => JournalArticle::STATUS_SUBMITTED,
        ]);

        $article = JournalArticle::where('title', 'Corporate Reputation Signals and Foreign Direct Investment')->first();
        $this->assertNotNull($article);
        $this->assertCount(1, $article->authors);

        $response->assertRedirect(route('journal.index'));
    }

    public function test_admin_can_manage_conferences_and_check_in_delegates(): void
    {
        $delegate = ConferenceDelegate::create([
            'conference_id' => $this->conference->id,
            'ticket_id' => $this->ticket->id,
            'first_name' => 'Femi',
            'last_name' => 'Ogunleye',
            'email' => 'femi@example.ng',
            'badge_code' => 'BANF-CONF-2026-CHECK1',
            'amount_paid' => 35000.00,
            'checked_in' => false,
        ]);

        // Admin summit overview
        $response = $this->actingAs($this->admin)->get(route('admin.conferences.show', $this->conference->id));
        $response->assertStatus(200);
        $response->assertSee('Femi Ogunleye');

        // Check in delegate
        $checkinResponse = $this->actingAs($this->admin)->post(route('admin.conferences.checkin', $delegate->id));
        $delegate->refresh();
        $this->assertTrue($delegate->checked_in);
        $this->assertNotNull($delegate->checked_in_at);
        $checkinResponse->assertRedirect();
    }

    public function test_admin_can_manage_journal_volumes_issues_and_manuscripts(): void
    {
        // Create new volume
        $volResponse = $this->actingAs($this->admin)->post(route('admin.journal.volumes.store'), [
            'volume_number' => 2,
            'year' => 2027,
            'title' => 'Volume 2 (2027)',
        ]);
        $volResponse->assertRedirect();
        $this->assertDatabaseHas('journal_volumes', ['volume_number' => 2]);

        // Publish manuscript
        $updateResponse = $this->actingAs($this->admin)->post(
            route('admin.journal.articles.update', $this->article->id),
            [
                'submission_status' => JournalArticle::STATUS_PUBLISHED,
                'issue_id' => $this->issue->id,
                'doi' => '10.5281/jbsm.2026.01.09',
                'page_start' => 50,
                'page_end' => 65,
            ]
        );
        $updateResponse->assertRedirect();

        $this->article->refresh();
        $this->assertEquals(JournalArticle::STATUS_PUBLISHED, $this->article->submission_status);
        $this->assertEquals('10.5281/jbsm.2026.01.09', $this->article->doi);
    }
}
