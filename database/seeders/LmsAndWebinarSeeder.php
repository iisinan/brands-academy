<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use App\Models\CourseResource;
use App\Models\InstructorSchedule;
use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LmsAndWebinarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?: User::first();

        // 1. Paid Flagship Short Course
        $course1 = Course::firstOrCreate(
            ['slug' => 'brand-strategy-and-visual-architecture-masterclass'],
            [
                'title' => 'Brand Strategy & Visual Architecture Masterclass',
                'code' => 'BC-STRAT-101',
                'track' => 'Brand Strategy',
                'short_description' => 'A master-level executive course covering category definition, strategic brand positioning, modular design systems, and IP portfolio governance.',
                'description' => "This flagship micro-credential course equips senior designers, brand strategists, and marketing directors with the frameworks required to build enduring brand equity.\n\nYou will master:\n1. The Brand DNA Archetype Matrix\n2. Modular Design Systems for Pan-African Expansion\n3. Trademark and CAC BN/RC Alignment\n4. Digital Transformation & Narrative Governance",
                'instructor_name' => 'Dr. Amina Danladi, FBA',
                'instructor_title' => 'Lead Strategist & Executive Council Member',
                'instructor_bio' => 'Dr. Danladi has consulted for leading banks, telcos, and FMCG brands across West Africa with 18+ years of visual identity and intellectual property practice.',
                'delivery_mode' => 'hybrid',
                'fee_type' => 'paid',
                'regular_price' => 25000.00,
                'member_price' => 18750.00,
                'meeting_provider' => 'google_meet',
                'meeting_link' => 'https://meet.google.com/ban-stra-teg',
                'meeting_instructions' => 'Interactive Google Meet classroom. Microphone must be muted upon joining.',
                'duration_weeks' => 4,
                'estimated_hours' => 14,
                'level' => 'Executive / Advanced',
                'is_published' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ]
        );

        // Modules & Lessons for Course 1
        $module1 = CourseModule::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Module 1: Strategic Foundations & Market Category'],
            [
                'description' => 'Unpack category creation, customer mental models, and brand positioning fundamentals.',
                'sort_order' => 1,
            ]
        );

        CourseLesson::firstOrCreate(
            ['course_module_id' => $module1->id, 'slug' => 'brand-dna-and-positioning-frameworks'],
            [
                'title' => 'Brand DNA & Positioning Frameworks',
                'content_type' => 'video',
                'video_provider' => 'youtube_unlisted',
                'video_id_or_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'body_text' => "### Core Takeaways\n\nA brand is not merely a logo; it is the emotional and intellectual contract between an organization and its constituents.\n\nKey pillars discussed in this lecture:\n- The Positioning Statement formula\n- Differentiation vs Distinctiveness\n- Protecting brand assets via CAC and IPO filings",
                'duration_minutes' => 20,
                'is_free_preview' => true,
                'sort_order' => 1,
            ]
        );

        CourseLesson::firstOrCreate(
            ['course_module_id' => $module1->id, 'slug' => 'competitive-differentiation-matrix'],
            [
                'title' => 'Competitive Differentiation & Category Audit',
                'content_type' => 'reading',
                'body_text' => "### Analyzing Category Landscape\n\nBefore executing design tokens or brand collateral, audit at least 5 primary and 3 secondary competitors in your jurisdictional market. Note color territories, verbal tropes, and price positioning.",
                'duration_minutes' => 15,
                'is_free_preview' => false,
                'sort_order' => 2,
            ]
        );

        $module2 = CourseModule::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Module 2: Design Systems & Live Executive Review'],
            [
                'description' => 'Scale typography, color harmony, and join the live Google Meet critique room.',
                'sort_order' => 2,
            ]
        );

        CourseLesson::firstOrCreate(
            ['course_module_id' => $module2->id, 'slug' => 'modular-typography-and-design-tokens'],
            [
                'title' => 'Modular Typography & Design Tokens',
                'content_type' => 'video',
                'video_provider' => 'youtube_unlisted',
                'video_id_or_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'body_text' => 'Learn how to construct accessible, multi-platform brand typography systems for mobile and print media.',
                'duration_minutes' => 25,
                'is_free_preview' => false,
                'sort_order' => 1,
            ]
        );

        CourseLesson::firstOrCreate(
            ['course_module_id' => $module2->id, 'slug' => 'live-google-meet-critique-clinic'],
            [
                'title' => 'Live Faculty Critique & Portfolio Review',
                'content_type' => 'live_session',
                'meeting_link' => 'https://meet.google.com/ban-stra-teg',
                'body_text' => 'Live cohort interactive session held on Google Meet. Bring your brand deck drafts for real-time faculty feedback.',
                'duration_minutes' => 60,
                'is_free_preview' => false,
                'sort_order' => 2,
            ]
        );

        // Quiz for Course 1
        $quiz1 = Quiz::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Brand Strategy & Governance Final Exam'],
            [
                'description' => 'Test your comprehension of brand architecture and differentiation matrices. 80% passing score required for certification.',
                'time_limit_minutes' => 15,
                'pass_percentage' => 80,
                'max_attempts' => 3,
                'is_required_for_certificate' => true,
                'is_published' => true,
            ]
        );

        $q1 = QuizQuestion::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'What is the primary difference between brand differentiation and brand distinctiveness?'],
            [
                'explanation' => 'Differentiation focuses on why consumers choose you based on perceived value, whereas distinctiveness focuses on mental availability through recognizable brand assets.',
                'points' => 1,
                'sort_order' => 1,
            ]
        );

        QuizOption::firstOrCreate(['quiz_question_id' => $q1->id, 'option_text' => 'Differentiation is why you are chosen; distinctiveness is how easily you are recognized.'], ['is_correct' => true, 'sort_order' => 1]);
        QuizOption::firstOrCreate(['quiz_question_id' => $q1->id, 'option_text' => 'They are identical concepts.'], ['is_correct' => false, 'sort_order' => 2]);
        QuizOption::firstOrCreate(['quiz_question_id' => $q1->id, 'option_text' => 'Differentiation is only for B2B brands.'], ['is_correct' => false, 'sort_order' => 3]);
        QuizOption::firstOrCreate(['quiz_question_id' => $q1->id, 'option_text' => 'Distinctiveness requires a patent filing.'], ['is_correct' => false, 'sort_order' => 4]);

        $q2 = QuizQuestion::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'In Nigerian commercial law, which registry protects business trading names vs brand logos?'],
            [
                'explanation' => 'CAC registers Business Names (Part B) and Companies (Part A), while the Trademark, Patent and Designs Registry (Federal Ministry of Industry, Trade & Investment) protects brand logos and wordmarks.',
                'points' => 1,
                'sort_order' => 2,
            ]
        );

        QuizOption::firstOrCreate(['quiz_question_id' => $q2->id, 'option_text' => 'CAC handles Business Names; the Trademarks Registry handles Logo/Wordmark protection.'], ['is_correct' => true, 'sort_order' => 1]);
        QuizOption::firstOrCreate(['quiz_question_id' => $q2->id, 'option_text' => 'CAC protects both logos and trademarks automatically.'], ['is_correct' => false, 'sort_order' => 2]);
        QuizOption::firstOrCreate(['quiz_question_id' => $q2->id, 'option_text' => 'Copyright automatically protects brand logos without registration.'], ['is_correct' => false, 'sort_order' => 3]);

        // Course Resources for Course 1
        CourseResource::firstOrCreate(
            ['course_id' => $course1->id, 'title' => 'Brand Strategy Positioning Canvas (Editable Guide)'],
            [
                'description' => 'A practical framework worksheet to map brand archetypes, value props, and category differentiation.',
                'file_type' => 'pdf',
                'file_size' => 2450000,
                'download_count' => 42,
                'external_url' => 'https://example.com/brand-canvas.pdf',
                'sort_order' => 1,
            ]
        );

        // Office Hours for Course 1
        if ($admin) {
            InstructorSchedule::firstOrCreate(
                ['course_id' => $course1->id, 'day_of_week' => 'wednesday'],
                [
                    'instructor_user_id' => $admin->id,
                    'start_time' => '14:00',
                    'end_time' => '16:00',
                    'slot_duration_minutes' => 20,
                    'meeting_provider' => 'google_meet',
                    'meeting_link' => 'https://meet.google.com/ban-stra-teg',
                    'is_active' => true,
                ]
            );
        }

        // 2. Free Micro-Course
        $course2 = Course::firstOrCreate(
            ['slug' => 'trademark-and-cac-compliance-for-founders'],
            [
                'title' => 'Trademark & CAC Compliance for Founders',
                'code' => 'BC-LEGAL-01',
                'track' => 'Brand Law & Intellectual Property',
                'short_description' => 'Essential legal guide on safeguarding your brand name, navigating Nigerian Trademark classes, and CAC BN registration.',
                'description' => 'Avoid costly brand disputes and trademark infringement. Learn how to conduct name availability searches, choose appropriate Nice classes, and lodge CAC filings correctly.',
                'instructor_name' => 'Barr. Ibrahim Bello, LL.M',
                'instructor_title' => 'Legal IP Consultant & Fellow',
                'delivery_mode' => 'self_paced',
                'fee_type' => 'free',
                'regular_price' => 0.00,
                'member_price' => 0.00,
                'duration_weeks' => 2,
                'estimated_hours' => 6,
                'level' => 'Foundational',
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 2,
            ]
        );

        $m2 = CourseModule::firstOrCreate(
            ['course_id' => $course2->id, 'title' => 'Module 1: Trademark Protection in Nigeria'],
            ['sort_order' => 1]
        );

        CourseLesson::firstOrCreate(
            ['course_module_id' => $m2->id, 'slug' => 'navigating-the-45-nice-classes'],
            [
                'title' => 'Navigating the 45 Nice Classification System',
                'content_type' => 'reading',
                'body_text' => 'Understanding which Nice class covers your products or services (e.g. Class 35 for retail/advertising, Class 42 for technology).',
                'duration_minutes' => 15,
                'is_free_preview' => true,
                'sort_order' => 1,
            ]
        );

        // 3. Webinars
        Webinar::firstOrCreate(
            ['slug' => 'emerging-african-brand-equity-in-2026'],
            [
                'title' => 'Emerging African Brand Equity: Scaling Pan-African Identities',
                'speaker_name' => 'Dr. Chidi Nwosu',
                'speaker_title' => 'Executive Director, Brand Standards Africa',
                'speaker_bio' => 'Dr. Nwosu has spearheaded regional identity transformations across 12 African nations.',
                'summary' => 'Explore how African enterprises are establishing global brand authority through cultural authenticity and rigorous IP protection.',
                'description' => "In this masterclass, Dr. Nwosu shares deep empirical insights on:\n- Transitioning from commodity trading to branded consumer goods\n- Overcoming cross-border intellectual property pitfalls in AfCFTA\n- Brand equity measurement frameworks for SMEs",
                'starts_at' => Carbon::now()->addDays(5)->setHour(16)->setMinute(0),
                'duration_minutes' => 75,
                'fee_type' => 'free',
                'regular_price' => 0.00,
                'member_price' => 0.00,
                'meeting_provider' => 'google_meet',
                'meeting_link' => 'https://meet.google.com/ban-web-inar',
                'status' => 'upcoming',
                'is_published' => true,
            ]
        );

        Webinar::firstOrCreate(
            ['slug' => 'sme-brand-identity-clinic-and-cac-bn-filing'],
            [
                'title' => 'SME Brand Identity Clinic & CAC Business Name Filing',
                'speaker_name' => 'Zainab Ahmed, CBA',
                'speaker_title' => 'Corporate Identity Lead',
                'speaker_bio' => 'Zainab directs SME brand accelerator cohorts at Brands Academy Nigeria Foundation.',
                'summary' => 'A hands-on workshop on trademarking logos, structuring CAC filings, and designing memorable visual identities on a startup budget.',
                'starts_at' => Carbon::now()->subDays(10)->setHour(15)->setMinute(0),
                'duration_minutes' => 60,
                'fee_type' => 'free',
                'regular_price' => 0.00,
                'member_price' => 0.00,
                'meeting_provider' => 'google_meet',
                'status' => 'concluded',
                'recording_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_published' => true,
            ]
        );
    }
}
