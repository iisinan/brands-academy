<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Member;
use App\Models\PortfolioSubmission;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopApplication;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Foundation Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@brandsacademy.org'],
            [
                'name' => 'Brands Academy Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Create Sample Member User
        $memberUser = User::firstOrCreate(
            ['email' => 'amina.k@example.com'],
            [
                'name' => 'Amina Kabir',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );

        $member1 = Member::firstOrCreate(
            ['email' => 'amina.k@example.com'],
            [
                'user_id' => $memberUser->id,
                'member_number' => 'BANF-MBR-2024-1001',
                'first_name' => 'Amina',
                'last_name' => 'Kabir',
                'phone' => '+234 803 123 4567',
                'category' => 'professional',
                'institution_or_company' => 'Apex Media Hub',
                'designation' => 'Brand Strategist',
                'state' => 'Kaduna',
                'country' => 'Nigeria',
                'status' => 'active',
                'bio' => 'Brand practitioner passionate about brand equity and narrative building for African SMEs.',
                'qr_code_token' => 'mbr-token-amina-1001',
                'joined_at' => Carbon::now()->subMonths(3),
            ]
        );

        $member2 = Member::firstOrCreate(
            ['email' => 'chidi.okafor@example.com'],
            [
                'member_number' => 'BANF-MBR-2024-1002',
                'first_name' => 'Chidi',
                'last_name' => 'Okafor',
                'phone' => '+234 802 987 6543',
                'category' => 'student',
                'institution_or_company' => 'Ahmadu Bello University',
                'designation' => 'Undergraduate (Mass Comm)',
                'state' => 'Kaduna',
                'country' => 'Nigeria',
                'status' => 'active',
                'bio' => 'Aspiring digital brand designer and storyteller.',
                'qr_code_token' => 'mbr-token-chidi-1002',
                'joined_at' => Carbon::now()->subMonths(1),
            ]
        );

        // 3. Create Realistic Workshops with Window Logic
        // Workshop 1: OPEN FOR APPLICATIONS (Foundations of Branding - CBA)
        $workshopOpen = Workshop::firstOrCreate(
            ['slug' => 'certified-brand-associate-cba-cohort-24b'],
            [
                'title' => 'Certified Brand Associate (CBA) — Cohort 2024-B',
                'track_type' => 'cba',
                'tagline' => 'Foundational certification in branding concepts, terminology and brand strategy.',
                'description' => 'A 6-week intensive foundational certification programme designed to close the gap between academic theory and industry-ready branding practice. Learners are paired with experienced practitioners and evaluated through applied assignments.',
                'curriculum_topics' => [
                    'Principles of Strategic Branding & Brand Architecture',
                    'Audience Research, Segmentation & Persona Mapping',
                    'Brand Identity, Tone of Voice & Visual Systems',
                    'Digital Marketing Communications & Campaign Tactics',
                    'Portfolio Project Presentation & Guided Mentorship',
                ],
                'delivery_mode' => 'hybrid',
                'venue' => 'Kaduna Training Center & Virtual Live Sessions',
                'fee_type' => 'subsidized',
                'fee_amount' => 15000.00,
                'capacity' => 45,
                'application_starts_at' => Carbon::now()->subDays(5),
                'application_deadline' => Carbon::now()->addDays(16),
                'starts_at' => Carbon::now()->addDays(21),
                'ends_at' => Carbon::now()->addDays(63),
                'instructor_name' => 'Prof. Samaila Mande & Industry Fellows',
                'status' => 'published',
                'is_featured' => true,
            ]
        );

        // Workshop 2: UPCOMING (Opening Soon - Certified Brand Strategist CBS)
        $workshopUpcoming = Workshop::firstOrCreate(
            ['slug' => 'certified-brand-strategist-cbs-cohort-25a'],
            [
                'title' => 'Certified Brand Strategist (CBS) — Cohort 2025-A',
                'track_type' => 'cbs',
                'tagline' => 'Intermediate professional track for practicing marketers and brand managers.',
                'description' => 'An advanced practitioner programme focusing on applied brand positioning, competitive differentiation, multi-channel rollout, and corporate communications.',
                'curriculum_topics' => [
                    'Advanced Brand Positioning & Category Creation',
                    'Brand Equity Valuation & Perception Audits',
                    'Multi-stakeholder Communications & Crisis PR',
                    'Client Pitching, Strategy Decks & Executive Reviews',
                ],
                'delivery_mode' => 'online',
                'venue' => 'Virtual Cohort Studio',
                'fee_type' => 'paid',
                'fee_amount' => 45000.00,
                'capacity' => 30,
                'application_starts_at' => Carbon::now()->addDays(10),
                'application_deadline' => Carbon::now()->addDays(30),
                'starts_at' => Carbon::now()->addDays(35),
                'ends_at' => Carbon::now()->addDays(85),
                'instructor_name' => 'Prof. Imam Yagana Babakura',
                'status' => 'published',
                'is_featured' => true,
            ]
        );

        // Workshop 3: APPLICATIONS CLOSED / IN SESSION (Community Free-Access Track)
        $workshopClosed = Workshop::firstOrCreate(
            ['slug' => 'community-youth-vocational-branding-bootcamp'],
            [
                'title' => 'Community & Youth Vocational Branding Bootcamp (Free Track)',
                'track_type' => 'community',
                'tagline' => '100% tuition-free vocational branding and digital skill training for underserved youth.',
                'description' => 'Empowering youth and marginalized communities with practical digital brand assets creation, freelance portfolio building, and small-business identity crafting.',
                'curriculum_topics' => [
                    'Visual Brand Design with Modern Digital Tools',
                    'Social Media Brand Management for Small Businesses',
                    'Freelancing, Client Invoicing & Ethics',
                ],
                'delivery_mode' => 'in_person',
                'venue' => 'Marafa Community Learning Center, Kaduna State',
                'fee_type' => 'free',
                'fee_amount' => 0.00,
                'capacity' => 60,
                'application_starts_at' => Carbon::now()->subDays(25),
                'application_deadline' => Carbon::now()->subDays(2),
                'starts_at' => Carbon::now()->addDays(3),
                'ends_at' => Carbon::now()->addDays(24),
                'instructor_name' => 'Titus Eveshoyan & Community Mentors',
                'status' => 'published',
                'is_featured' => false,
            ]
        );

        // 4. Create Sample Applications
        $app1 = WorkshopApplication::firstOrCreate(
            ['applicant_email' => 'amina.k@example.com', 'workshop_id' => $workshopOpen->id],
            [
                'member_id' => $member1->id,
                'user_id' => $memberUser->id,
                'applicant_name' => 'Amina Kabir',
                'applicant_phone' => '+234 803 123 4567',
                'applicant_organization' => 'Apex Media Hub',
                'statement_of_purpose' => 'I want to advance my skills from tactical social media management to foundational brand strategy and gain the Certified Brand Associate credential.',
                'portfolio_link' => 'https://behance.net/aminakabir',
                'scholarship_requested' => false,
                'status' => 'pending',
            ]
        );

        $app2 = WorkshopApplication::firstOrCreate(
            ['applicant_email' => 'chidi.okafor@example.com', 'workshop_id' => $workshopOpen->id],
            [
                'member_id' => $member2->id,
                'applicant_name' => 'Chidi Okafor',
                'applicant_phone' => '+234 802 987 6543',
                'applicant_organization' => 'Ahmadu Bello University',
                'statement_of_purpose' => 'As a final year student, I want to obtain the CBA credential before graduation to enter the job market with demonstrable industry skills.',
                'portfolio_link' => 'https://github.com/chidiokafor',
                'scholarship_requested' => true,
                'scholarship_reason' => 'Currently a full-time university student with limited financial means, applying for the youth educational subsidy.',
                'status' => 'accepted',
                'reviewed_at' => Carbon::now()->subDay(),
            ]
        );

        // 5. Create a Sample Completed Certificate for Testing Verification
        $sampleCertToken = '8a2b3c4d-5e6f-7a8b-9c0d-1e2f3a4b5c6d';
        Certificate::firstOrCreate(
            ['certificate_number' => 'BANF-CERT-2024-00108'],
            [
                'verification_token' => $sampleCertToken,
                'workshop_id' => $workshopOpen->id,
                'workshop_application_id' => $app2->id,
                'member_id' => $member2->id,
                'recipient_name' => 'Chidi Okafor',
                'recipient_email' => 'chidi.okafor@example.com',
                'course_title' => 'Certified Brand Associate (CBA) — Tier 1 Foundation',
                'track_tier' => 'Tier 1: Certified Brand Associate (CBA)',
                'issued_at' => Carbon::now()->subDays(10)->toDateString(),
                'email_status' => 'sent',
                'email_sent_at' => Carbon::now()->subDays(10),
            ]
        );

        // 6. Create a Sample Portfolio Submission for evaluation testing
        PortfolioSubmission::firstOrCreate(
            ['workshop_application_id' => $app2->id],
            [
                'workshop_id' => $workshopOpen->id,
                'member_id' => $member2->id,
                'title' => 'Brand Strategy & Visual Guidelines for AgriGrowth Nigeria',
                'description' => 'A comprehensive brand positioning deck defining market category, customer archetypes, brand architecture, and a complete visual identity kit.',
                'deck_url' => 'https://behance.net/gallery/12345/AgriGrowth-Branding',
                'deliverables' => [
                    'Strategic Positioning Matrix',
                    'Tone of Voice & Messaging Guidelines',
                    'Logo Suite & Color Harmony System',
                ],
                'status' => 'submitted',
            ]
        );
    }
}
