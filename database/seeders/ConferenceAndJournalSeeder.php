<?php

namespace Database\Seeders;

use App\Models\ArticleAuthor;
use App\Models\CallForPaper;
use App\Models\Conference;
use App\Models\ConferenceDelegate;
use App\Models\ConferenceTicket;
use App\Models\JournalArticle;
use App\Models\JournalIssue;
use App\Models\JournalVolume;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ConferenceAndJournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@brandsacademy.org')->first() ?? User::where('role', 'admin')->first();
        $memberUser = User::where('email', 'member@brandsacademy.org')->first() ?? User::where('role', 'member')->first();
        $member = $memberUser ? Member::where('user_id', $memberUser->id)->first() : null;

        // 1. Annual Conference
        $conference = Conference::firstOrCreate(
            ['slug' => 'nigeria-brand-leadership-summit-2026'],
            [
                'title' => '2026 Nigeria Brand Leadership Summit',
                'theme' => 'Brand Valuation, Equity & Policy in Emerging African Markets',
                'year' => 2026,
                'venue' => 'Congress Hall, Transcorp Hilton, Abuja (Hybrid Plenary)',
                'starts_at' => Carbon::now()->addMonths(2)->startOfDay()->addHours(9),
                'ends_at' => Carbon::now()->addMonths(2)->addDays(2)->startOfDay()->addHours(17),
                'description' => 'The premier annual gathering of chief brand officers, university professors, intellectual property attorneys, and public policy makers. Convened by Brands Academy Nigeria Foundation to advance evidence-based brand equity governance.',
                'keynote_speakers' => [
                    [
                        'name' => 'Prof. Samaila Mande',
                        'title' => 'Chairman, Board of Trustees',
                        'organization' => 'National Open University of Nigeria & Brands Academy',
                    ],
                    [
                        'name' => 'Dr. Okoli Emmanuel Chibuzo',
                        'title' => 'Trustee & Senior Brand Strategist',
                        'organization' => 'Brands Academy Foundation',
                    ],
                    [
                        'name' => 'Titus Eveshoyan',
                        'title' => 'Secretary, Board of Trustees',
                        'organization' => 'Brands Academy Legal Secretariat',
                    ],
                ],
                'schedule_agenda' => [
                    ['day' => 'Day 1', 'time' => '09:00 AM', 'title' => 'Opening Plenary: Measuring Brand Equity in Nigerian Markets'],
                    ['day' => 'Day 1', 'time' => '02:00 PM', 'title' => 'Academic Paper Presentations: Track A (IP & Trademarks)'],
                    ['day' => 'Day 2', 'time' => '10:00 AM', 'title' => 'Executive Panel: CAC Corporate Governance & Intangible Assets'],
                    ['day' => 'Day 2', 'time' => '06:00 PM', 'title' => 'Gala Dinner & Presidential Brand Leadership Awards'],
                ],
                'is_active' => true,
                'cfp_open' => true,
                'cfp_deadline' => Carbon::now()->addMonth()->toDateString(),
            ]
        );

        // Conference Tickets
        $ticketStudent = ConferenceTicket::firstOrCreate(
            ['conference_id' => $conference->id, 'name' => 'Student Delegate'],
            [
                'regular_price' => 15000.00,
                'member_price' => 11250.00,
                'quantity_available' => 100,
                'quantity_sold' => 8,
                'benefits' => ['Access to all plenary & poster sessions', 'Digital conference pack & summary book', 'Digital certificate of attendance'],
            ]
        );

        $ticketGeneral = ConferenceTicket::firstOrCreate(
            ['conference_id' => $conference->id, 'name' => 'General Delegate Pass'],
            [
                'regular_price' => 35000.00,
                'member_price' => 26250.00,
                'quantity_available' => 300,
                'quantity_sold' => 24,
                'benefits' => ['Full 2-day summit badge & kit', 'Plenary luncheons & executive networking breaks', 'Certificate of Participation & accredited CPD hours'],
            ]
        );

        ConferenceTicket::firstOrCreate(
            ['conference_id' => $conference->id, 'name' => 'VIP & Corporate Delegation'],
            [
                'regular_price' => 85000.00,
                'member_price' => 63750.00,
                'quantity_available' => 50,
                'quantity_sold' => 6,
                'benefits' => ['VIP front-row plenary seating', 'Exclusive Executive Speakers Lounge access', 'Presidential Gala Dinner seat', 'Hardcover printed JBSM Volume 1'],
            ]
        );

        // Sample Registered Delegate
        ConferenceDelegate::firstOrCreate(
            ['badge_code' => 'BANF-CONF-2026-LEAD01'],
            [
                'conference_id' => $conference->id,
                'ticket_id' => $ticketGeneral->id,
                'user_id' => $memberUser?->id,
                'first_name' => $member?->first_name ?? 'Samuel',
                'last_name' => $member?->last_name ?? 'Okonkwo',
                'email' => $memberUser?->email ?? 'samuel@apexbrand.ng',
                'phone' => '+234 803 111 2233',
                'organization' => 'Apex Brand Dynamics',
                'designation' => 'Managing Partner',
                'amount_paid' => 26250.00,
                'payment_reference' => 'CONF-REF-9921',
                'checked_in' => false,
            ]
        );

        // Sample Call For Paper
        CallForPaper::firstOrCreate(
            [
                'conference_id' => $conference->id,
                'title' => 'Empirical Assessment of Brand Valuation Frameworks in Nigerian Commercial Banking',
            ],
            [
                'user_id' => $memberUser?->id,
                'author_name' => 'Dr. Chidi Nwosu & Prof. Samaila Mande',
                'author_email' => 'cnwosu@unilag.edu.ng',
                'author_institution' => 'University of Lagos, Faculty of Business Administration',
                'abstract_text' => 'This empirical paper assesses five dominant brand valuation frameworks applied across Tier-1 commercial banks listed on the Nigerian Exchange (NGX). Findings show substantial discrepancies in goodwill amortization and market capitalization correlations.',
                'keywords' => 'Brand Valuation, Intangible Assets, Banking, NGX, Africa',
                'review_status' => CallForPaper::STATUS_ACCEPTED_PRESENTATION,
                'reviewer_feedback' => 'Accepted for oral presentation in Plenary Session B (Financial Brand Assets).',
            ]
        );

        // 2. Journal of Brand Strategy & Management (JBSM)
        $volume1 = JournalVolume::firstOrCreate(
            ['volume_number' => 1, 'year' => 2026],
            [
                'title' => 'Volume 1 (2026)',
                'is_published' => true,
            ]
        );

        $issue1 = JournalIssue::firstOrCreate(
            ['volume_id' => $volume1->id, 'issue_number' => 1],
            [
                'title' => 'Inaugural Issue on African Brand Equity & Market Signals',
                'published_date' => Carbon::now()->subWeeks(2)->toDateString(),
                'is_published' => true,
            ]
        );

        // Article 1
        $article1 = JournalArticle::firstOrCreate(
            ['slug' => 'strategic-brand-equity-dynamics-and-firm-performance-in-sub-saharan-africa'],
            [
                'issue_id' => $issue1->id,
                'submitted_by_user_id' => $adminUser?->id,
                'title' => 'Strategic Brand Equity Dynamics and Firm Performance in Sub-Saharan Africa',
                'abstract' => 'In emerging African consumer markets, brand equity serves not merely as a marketing differentiator but as a core determinant of equity cost, institutional credit rating, and export competitiveness. Drawing upon cross-sectional data from 120 consumer goods enterprises in Nigeria, Ghana, and Kenya, this study formulates an endogenous valuation model demonstrating a 3.4x valuation multiplier for verified trademarked brands versus unaccredited market competitors.',
                'keywords' => 'Brand Equity, Firm Performance, Market Signaling, Emerging Economies, Sub-Saharan Africa',
                'doi' => '10.5281/jbsm.2026.01.01',
                'page_start' => 1,
                'page_end' => 18,
                'submission_status' => JournalArticle::STATUS_PUBLISHED,
                'views_count' => 184,
                'downloads_count' => 52,
                'published_at' => Carbon::now()->subWeeks(2),
            ]
        );

        ArticleAuthor::firstOrCreate(
            ['article_id' => $article1->id, 'full_name' => 'Prof. Samaila Mande'],
            [
                'affiliation' => 'Brands Academy Nigeria Foundation & National Open University of Nigeria',
                'email' => 'smande@brandsacademy.org',
                'orcid_id' => '0000-0002-8192-3819',
                'is_corresponding' => true,
                'sort_order' => 1,
            ]
        );

        ArticleAuthor::firstOrCreate(
            ['article_id' => $article1->id, 'full_name' => 'Dr. Okoli Emmanuel Chibuzo'],
            [
                'affiliation' => 'Department of Marketing, University of Nigeria, Nsukka',
                'email' => 'emmanuel.okoli@unn.edu.ng',
                'is_corresponding' => false,
                'sort_order' => 2,
            ]
        );

        // Article 2
        $article2 = JournalArticle::firstOrCreate(
            ['slug' => 'intellectual-property-governance-and-brand-counterfeiting-defense-in-west-africa'],
            [
                'issue_id' => $issue1->id,
                'submitted_by_user_id' => $adminUser?->id,
                'title' => 'Intellectual Property Governance and Brand Counterfeiting Defense in West Africa',
                'abstract' => 'Counterfeiting and illicit trade represent over $4.2 billion in annual losses across ECOWAS states. This legal-economic treatise explores the jurisdictional interplay between Nigerian statutory trademark protection (Trade Marks Act Cap T13 LFN 2004), CAC corporate status registration, and customs border seizure enforcement.',
                'keywords' => 'Intellectual Property, Trademark Infringement, Counterfeiting, CAC, Trade Marks Act, Nigeria',
                'doi' => '10.5281/jbsm.2026.01.02',
                'page_start' => 19,
                'page_end' => 36,
                'submission_status' => JournalArticle::STATUS_PUBLISHED,
                'views_count' => 126,
                'downloads_count' => 38,
                'published_at' => Carbon::now()->subWeek(),
            ]
        );

        ArticleAuthor::firstOrCreate(
            ['article_id' => $article2->id, 'full_name' => 'Titus Eveshoyan, Esq.'],
            [
                'affiliation' => 'Bar & Legal Secretariat, Brands Academy Nigeria Foundation',
                'email' => 'titus@brandsacademy.org',
                'is_corresponding' => true,
                'sort_order' => 1,
            ]
        );
    }
}
