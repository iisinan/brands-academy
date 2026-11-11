<?php

namespace Database\Seeders;

use App\Models\Conference;
use App\Models\ConferenceSchedule;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseReview;
use App\Models\LessonNote;
use App\Models\User;
use App\Models\Webinar;
use App\Models\WebinarQuestion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EcosystemExtensionsSeeder extends Seeder
{
    /**
     * Run the database seeds for Phase 6 enhancements.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?: User::first();
        $memberUser = User::where('email', 'amina.k@example.com')->first() ?: User::where('role', 'member')->first();

        // 1. Conference Multi-Day Plenary Schedules
        $conference = Conference::where('slug', 'nigeria-brand-leadership-summit-2026')->first();
        if ($conference) {
            $startDate = $conference->starts_at ? $conference->starts_at->copy() : Carbon::now()->addMonths(2);

            ConferenceSchedule::firstOrCreate(
                [
                    'conference_id' => $conference->id,
                    'session_title' => 'Opening Plenary: Measuring Brand Equity in African Markets',
                ],
                [
                    'day_number' => 1,
                    'day_date' => $startDate->toDateString(),
                    'start_time' => '09:00 AM',
                    'end_time' => '10:30 AM',
                    'session_description' => 'Keynote presentation exploring empirical brand equity valuation models and statutory intangible asset classification for emerging markets.',
                    'speaker_name' => 'Prof. Samaila Mande',
                    'hall_or_stream' => 'Main Congress Hall (Hybrid Stream)',
                    'sort_order' => 1,
                ]
            );

            ConferenceSchedule::firstOrCreate(
                [
                    'conference_id' => $conference->id,
                    'session_title' => 'Academic Paper Presentations: Track A - IP Law, Trademarks & Brand Equity',
                ],
                [
                    'day_number' => 1,
                    'day_date' => $startDate->toDateString(),
                    'start_time' => '11:00 AM',
                    'end_time' => '01:00 PM',
                    'session_description' => 'Peer-reviewed research manuscripts discussing Nice Classification governance, patent filings under NOTAP, and corporate reputation disputes.',
                    'speaker_name' => 'Dr. Okoli Emmanuel Chibuzo',
                    'hall_or_stream' => 'Executive Hall B',
                    'sort_order' => 2,
                ]
            );

            ConferenceSchedule::firstOrCreate(
                [
                    'conference_id' => $conference->id,
                    'session_title' => 'Executive Masterclass: Valuation of Intangible Assets for Nigerian Corporates',
                ],
                [
                    'day_number' => 1,
                    'day_date' => $startDate->toDateString(),
                    'start_time' => '02:00 PM',
                    'end_time' => '04:00 PM',
                    'session_description' => 'Hands-on clinic for corporate counsel, CFOs, and agency founders on auditing brand goodwill, registered trademarks, and software IP.',
                    'speaker_name' => 'Titus Eveshoyan, Esq.',
                    'hall_or_stream' => 'Syndicate Room 1',
                    'sort_order' => 3,
                ]
            );

            ConferenceSchedule::firstOrCreate(
                [
                    'conference_id' => $conference->id,
                    'session_title' => 'Panel Symposium: CAMA 2020 Compliance & Brand Registry Governance',
                ],
                [
                    'day_number' => 2,
                    'day_date' => $startDate->copy()->addDay()->toDateString(),
                    'start_time' => '09:30 AM',
                    'end_time' => '11:30 AM',
                    'session_description' => 'High-level policy dialogue with regulatory directors on post-incorporation filings, annual returns, and safeguarding trademark rights against passing off.',
                    'speaker_name' => 'Director of Compliance, CAC / Special Guests',
                    'hall_or_stream' => 'Main Congress Hall',
                    'sort_order' => 4,
                ]
            );

            ConferenceSchedule::firstOrCreate(
                [
                    'conference_id' => $conference->id,
                    'session_title' => 'Best Paper Awards, Induction of Certified Brand Fellows & Communique',
                ],
                [
                    'day_number' => 2,
                    'day_date' => $startDate->copy()->addDay()->toDateString(),
                    'start_time' => '02:30 PM',
                    'end_time' => '04:30 PM',
                    'session_description' => 'Celebratory plenary presenting the JBSM Best Research Award, conferment of FBA professional credentials, and publication of the official summit declaration.',
                    'speaker_name' => 'Council of Fellows Presiding Officers',
                    'hall_or_stream' => 'Grand Ballroom',
                    'sort_order' => 5,
                ]
            );
        }

        // 2. Course Reviews & Ratings
        $course = Course::where('slug', 'brand-strategy-and-visual-architecture-masterclass')->first() ?: Course::first();
        if ($course && $memberUser) {
            CourseReview::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'user_id' => $memberUser->id,
                ],
                [
                    'rating' => 5,
                    'title' => 'Rigorous and directly applicable to corporate identity practice in Nigeria',
                    'comment' => "The module on brand DNA archetypes and modular visual architecture completely elevated how our agency pitches and executes branding assignments.\n\nThe 1-on-1 Google Meet office hours session with the lead instructor provided critical clarity on trademark class definitions before our client submitted their CAC filing.",
                    'is_verified_learner' => true,
                    'is_published' => true,
                ]
            );
        }

        // 3. Lesson Notes
        if ($course && $memberUser) {
            $lesson = CourseLesson::whereHas('module', fn ($q) => $q->where('course_id', $course->id))->first();
            if ($lesson) {
                LessonNote::firstOrCreate(
                    [
                        'lesson_id' => $lesson->id,
                        'user_id' => $memberUser->id,
                    ],
                    [
                        'notes' => "Key Takeaways from {$lesson->title}:\n- Brand equity is rooted in mental availability (perceptual salience) and physical availability (distribution).\n- When filing trademarks with the registry, always ensure class 35 (advertising/business) and class 42 (design/technology) are protected together.\n- Follow up during instructor office hours regarding franchise brand architecture.",
                    ]
                );
            }
        }

        // 4. Webinar Questions & AMA Queue
        $webinar = Webinar::first();
        if ($webinar) {
            WebinarQuestion::firstOrCreate(
                [
                    'webinar_id' => $webinar->id,
                    'question' => 'How can homegrown African consumer brands protect their trademark positioning against multinational infringements prior to international Madrid Protocol expansion?',
                ],
                [
                    'user_id' => $memberUser?->id,
                    'attendee_name' => $memberUser?->name ?? 'Amina Kabir',
                    'attendee_organization' => 'Apex Media Hub',
                    'upvotes_count' => 14,
                    'is_answered' => true,
                ]
            );

            WebinarQuestion::firstOrCreate(
                [
                    'webinar_id' => $webinar->id,
                    'question' => 'What are the statutory consequences of operating a business under a proposed trade name before the CAC certificate is officially issued?',
                ],
                [
                    'user_id' => null,
                    'attendee_name' => 'Chinedu Eze',
                    'attendee_organization' => 'Enugu Tech Hub',
                    'upvotes_count' => 9,
                    'is_answered' => false,
                ]
            );

            WebinarQuestion::firstOrCreate(
                [
                    'webinar_id' => $webinar->id,
                    'question' => 'Will the session slides and the Brand Valuation Excel model be shared with registered participants after the Google Meet session?',
                ],
                [
                    'user_id' => null,
                    'attendee_name' => 'Dr. Folashade Adeyemi',
                    'attendee_organization' => 'Pan-Atlantic University',
                    'upvotes_count' => 5,
                    'is_answered' => true,
                ]
            );
        }
    }
}
