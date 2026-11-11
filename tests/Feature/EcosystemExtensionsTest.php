<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Conference;
use App\Models\ConferenceSchedule;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use App\Models\CourseReview;
use App\Models\Member;
use App\Models\ServiceFiling;
use App\Models\User;
use App\Models\Webinar;
use App\Models\WebinarQuestion;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcosystemExtensionsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected User $memberUser;

    protected Member $member;

    protected Course $course;

    protected CourseLesson $lesson;

    protected Webinar $webinar;

    protected Conference $conference;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => UserRole::Member,
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

        $this->course = Course::create([
            'title' => 'Advanced Brand Law & Governance',
            'slug' => 'advanced-brand-law-governance',
            'code' => 'BL-ADV-501',
            'track' => 'Brand Strategy',
            'delivery_mode' => 'online_self_paced',
            'fee_type' => 'free',
            'regular_price' => 0,
            'member_price' => 0,
            'duration_weeks' => 3,
            'estimated_hours' => 10,
            'is_published' => true,
        ]);

        $module = CourseModule::create([
            'course_id' => $this->course->id,
            'title' => 'Module 1: Principles of IP Protection',
            'sort_order' => 1,
        ]);

        $this->lesson = CourseLesson::create([
            'course_module_id' => $module->id,
            'title' => 'Trademark Classification & Madrid System',
            'slug' => 'trademark-classification-madrid-system',
            'content_type' => 'video',
            'duration_minutes' => 25,
            'sort_order' => 1,
        ]);

        $this->webinar = Webinar::create([
            'title' => 'Corporate Identity in African Markets',
            'slug' => 'corporate-identity-african-markets',
            'summary' => 'Executive session on brand building.',
            'speaker_name' => 'Prof. Samaila Mande',
            'speaker_title' => 'Chairman, BOT',
            'starts_at' => Carbon::now()->addDays(5),
            'duration_minutes' => 90,
            'meeting_provider' => 'google_meet',
            'meeting_link' => 'https://meet.google.com/ban-test-room',
            'fee_type' => 'free',
            'is_published' => true,
        ]);

        $this->conference = Conference::create([
            'title' => 'National Brand Summit 2026',
            'slug' => 'national-brand-summit-2026',
            'year' => 2026,
            'venue' => 'Congress Hall, Abuja',
            'starts_at' => Carbon::now()->addMonths(1),
            'ends_at' => Carbon::now()->addMonths(1)->addDays(2),
            'description' => 'Annual conference of Brand practitioners.',
            'is_active' => true,
        ]);
    }

    public function test_user_can_submit_course_review_and_average_rating_updates(): void
    {
        CourseEnrollment::create([
            'user_id' => $this->memberUser->id,
            'course_id' => $this->course->id,
            'payment_status' => 'paid',
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);

        $response = $this->actingAs($this->memberUser)
            ->post(route('courses.reviews.store', $this->course->slug), [
                'rating' => 5,
                'title' => 'Outstanding practical masterclass',
                'comment' => 'The modules on trademark filings and design systems gave our team concrete frameworks to execute.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('course_reviews', [
            'course_id' => $this->course->id,
            'user_id' => $this->memberUser->id,
            'rating' => 5,
            'is_verified_learner' => true,
        ]);

        // Second review
        $anotherUser = User::factory()->create(['email_verified_at' => now()]);
        CourseReview::create([
            'course_id' => $this->course->id,
            'user_id' => $anotherUser->id,
            'rating' => 3,
            'comment' => 'Solid foundational knowledge.',
            'is_published' => true,
        ]);

        $this->assertEquals(4.0, $this->course->fresh()->averageRating());

        // Check on course page
        $pageResponse = $this->get(route('courses.show', $this->course->slug));
        $pageResponse->assertOk();
        $pageResponse->assertSee('Outstanding practical masterclass');
        $pageResponse->assertSee('Verified Enrolled');
    }

    public function test_student_can_save_and_retrieve_lesson_notes(): void
    {
        CourseEnrollment::create([
            'user_id' => $this->memberUser->id,
            'course_id' => $this->course->id,
            'payment_status' => 'paid',
            'progress_percentage' => 25,
        ]);

        $postResponse = $this->actingAs($this->memberUser)
            ->post(route('member.courses.lessons.notes', [
                'slug' => $this->course->slug,
                'lessonId' => $this->lesson->id,
            ]), [
                'notes' => 'Remember to register Nice classes 35 and 42 for brand tech startups.',
            ]);

        $postResponse->assertRedirect();
        $postResponse->assertSessionHas('success');

        $this->assertDatabaseHas('lesson_notes', [
            'lesson_id' => $this->lesson->id,
            'user_id' => $this->memberUser->id,
            'notes' => 'Remember to register Nice classes 35 and 42 for brand tech startups.',
        ]);

        // JSON format check
        $jsonResponse = $this->actingAs($this->memberUser)
            ->postJson(route('member.courses.lessons.notes', [
                'slug' => $this->course->slug,
                'lessonId' => $this->lesson->id,
            ]), [
                'notes' => 'Updated notes: check section 18 of CAMA.',
            ]);

        $jsonResponse->assertOk();
        $jsonResponse->assertJson([
            'success' => true,
            'message' => 'Notes saved successfully.',
        ]);

        // Retrieve on learn page
        $learnPage = $this->actingAs($this->memberUser)
            ->get(route('member.courses.learn', [
                'slug' => $this->course->slug,
                'lesson' => $this->lesson->slug,
                'tab' => 'notes',
            ]));

        $learnPage->assertOk();
        $learnPage->assertSee('check section 18 of CAMA');
    }

    public function test_attendee_can_submit_webinar_question_and_upvote(): void
    {
        $response = $this->actingAs($this->memberUser)
            ->post(route('webinars.questions.store', $this->webinar->slug), [
                'attendee_name' => 'Amina Kabir',
                'attendee_organization' => 'Apex Media',
                'question' => 'How can FMCG startups protect their trade dress against copycats?',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $question = WebinarQuestion::where('webinar_id', $this->webinar->id)->first();
        $this->assertNotNull($question);
        $this->assertEquals('Amina Kabir', $question->attendee_name);
        $this->assertEquals(0, $question->upvotes_count);

        // Upvote
        $upvoteResponse = $this->post(route('webinars.questions.upvote', [
            'slug' => $this->webinar->slug,
            'questionId' => $question->id,
        ]));

        $upvoteResponse->assertRedirect();
        $this->assertEquals(1, $question->fresh()->upvotes_count);

        // JSON upvote
        $jsonUpvote = $this->postJson(route('webinars.questions.upvote', [
            'slug' => $this->webinar->slug,
            'questionId' => $question->id,
        ]));

        $jsonUpvote->assertOk();
        $jsonUpvote->assertJson([
            'success' => true,
            'upvotes_count' => 2,
        ]);

        // View on webinar detail page
        $webinarPage = $this->get(route('webinars.show', $this->webinar->slug));
        $webinarPage->assertOk();
        $webinarPage->assertSee('How can FMCG startups protect their trade dress');
    }

    public function test_brand_name_precheck_api_returns_availability_and_conflict_detection(): void
    {
        // 1. Empty name validation
        $emptyRes = $this->getJson(route('services.precheck'));
        $emptyRes->assertStatus(422);

        // 2. Available name
        $availRes = $this->getJson(route('services.precheck', ['name' => 'Vanguard Quantum Technologies']));
        $availRes->assertOk();
        $availRes->assertJson([
            'available' => true,
            'matches_count' => 0,
        ]);

        // 3. Existing filing conflict
        ServiceFiling::create([
            'tracking_code' => 'BANF-CAC-2026-TEST',
            'filing_type' => ServiceFiling::TYPE_CAC_BUSINESS_NAME,
            'proposed_name_1' => 'Zenith Analytics Global',
            'business_nature' => 'Data analytics',
            'business_address' => '12 Victoria Island',
            'headquarters_state' => 'Lagos',
            'client_first_name' => 'John',
            'client_last_name' => 'Doe',
            'client_email' => 'john@example.com',
            'client_phone' => '+2348011223344',
            'total_fee' => 28000,
            'status' => ServiceFiling::STATUS_SUBMITTED,
        ]);

        $conflictRes = $this->getJson(route('services.precheck', ['name' => 'Zenith Analytics']));
        $conflictRes->assertOk();
        $conflictRes->assertJson([
            'available' => false,
            'matches_count' => 1,
            'similar' => ['Zenith Analytics Global'],
        ]);
    }

    public function test_conference_schedules_display_on_conference_page(): void
    {
        ConferenceSchedule::create([
            'conference_id' => $this->conference->id,
            'day_number' => 1,
            'day_date' => Carbon::now()->addMonths(1)->toDateString(),
            'start_time' => '09:00 AM',
            'end_time' => '10:30 AM',
            'session_title' => 'Plenary: Brand Equity & Legal Governance in West Africa',
            'session_description' => 'Keynote session with council members.',
            'speaker_name' => 'Prof. Samaila Mande',
            'hall_or_stream' => 'Main Congress Hall',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('conferences.show', $this->conference->slug));
        $response->assertOk();
        $response->assertSee('Plenary: Brand Equity & Legal Governance in West Africa');
        $response->assertSee('09:00 AM - 10:30 AM');
        $response->assertSee('Main Congress Hall');
        $response->assertSee('Prof. Samaila Mande');
    }
}
