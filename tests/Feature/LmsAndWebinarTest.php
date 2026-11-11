<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use App\Models\Member;
use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Models\Webinar;
use App\Services\LmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LmsAndWebinarTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $memberUser;

    protected Member $member;

    protected Course $course;

    protected CourseModule $module;

    protected CourseLesson $lesson1;

    protected CourseLesson $lesson2;

    protected Quiz $quiz;

    protected Webinar $webinar;

    protected function setUp(): void
    {
        parent::setUp();

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

        $this->course = Course::create([
            'title' => 'Brand Strategy & Identity Mastery',
            'slug' => 'brand-strategy-and-identity-mastery',
            'track' => 'Brand Strategy',
            'delivery_mode' => 'hybrid',
            'fee_type' => 'paid',
            'regular_price' => 20000.00,
            'member_price' => 15000.00,
            'meeting_provider' => 'google_meet',
            'meeting_link' => 'https://meet.google.com/abc-defg-hij',
            'duration_weeks' => 4,
            'estimated_hours' => 10,
            'level' => 'Intermediate',
            'is_published' => true,
        ]);

        $this->module = CourseModule::create([
            'course_id' => $this->course->id,
            'title' => 'Module 1: Positioning',
            'sort_order' => 1,
        ]);

        $this->lesson1 = CourseLesson::create([
            'course_module_id' => $this->module->id,
            'title' => 'Positioning Theory',
            'slug' => 'positioning-theory',
            'content_type' => 'video',
            'video_provider' => 'youtube_unlisted',
            'video_id_or_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_minutes' => 15,
            'is_free_preview' => true,
            'sort_order' => 1,
        ]);

        $this->lesson2 = CourseLesson::create([
            'course_module_id' => $this->module->id,
            'title' => 'Live Strategy Session',
            'slug' => 'live-strategy-session',
            'content_type' => 'live_session',
            'duration_minutes' => 60,
            'sort_order' => 2,
        ]);

        $this->quiz = Quiz::create([
            'course_id' => $this->course->id,
            'title' => 'Positioning Assessment',
            'time_limit_minutes' => 15,
            'pass_percentage' => 80,
            'max_attempts' => 3,
            'is_required_for_certificate' => true,
            'is_published' => true,
        ]);

        $question = QuizQuestion::create([
            'quiz_id' => $this->quiz->id,
            'question_text' => 'What is brand equity?',
            'points' => 1,
            'sort_order' => 1,
        ]);

        QuizOption::create([
            'quiz_question_id' => $question->id,
            'option_text' => 'The commercial value derived from consumer perception.',
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        QuizOption::create([
            'quiz_question_id' => $question->id,
            'option_text' => 'The cost of trademark legal fees.',
            'is_correct' => false,
            'sort_order' => 2,
        ]);

        $this->webinar = Webinar::create([
            'title' => 'African Brand Architecture 2026',
            'slug' => 'african-brand-architecture-2026',
            'speaker_name' => 'Dr. Fatima Danladi',
            'starts_at' => now()->addDays(3),
            'duration_minutes' => 60,
            'fee_type' => 'free',
            'meeting_provider' => 'google_meet',
            'meeting_link' => 'https://meet.google.com/test-meet',
            'is_published' => true,
        ]);
    }

    public function test_public_courses_catalog_and_filters_render(): void
    {
        $response = $this->get(route('courses.index'));
        $response->assertStatus(200);
        $response->assertSee('Executive Short Courses');
        $response->assertSee('Brand Strategy');

        // Test filter by track
        $filterResponse = $this->get(route('courses.index', ['track' => 'Brand Strategy']));
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('Brand Strategy');
    }

    public function test_public_course_show_page_renders_with_syllabus(): void
    {
        $response = $this->get(route('courses.show', $this->course->slug));
        $response->assertStatus(200);
        $response->assertSee('Module 1: Positioning');
        $response->assertSee('Positioning Theory');
        $response->assertSee('Live Strategy Session');
    }

    public function test_member_discount_calculated_correctly(): void
    {
        $guestTuition = $this->course->calculateTuitionFor(null);
        $this->assertEquals(20000.00, $guestTuition);

        $memberTuition = $this->course->calculateTuitionFor($this->memberUser);
        $this->assertEquals(15000.00, $memberTuition);
    }

    public function test_enrollment_and_classroom_access(): void
    {
        /** @var LmsService $lms */
        $lms = app(LmsService::class);
        $enrollment = $lms->enroll($this->memberUser, $this->course, 'free', null, 0.0);

        $this->assertDatabaseHas('course_enrollments', [
            'user_id' => $this->memberUser->id,
            'course_id' => $this->course->id,
        ]);

        $response = $this->actingAs($this->memberUser)
            ->get(route('member.courses.learn', $this->course->slug));

        $response->assertStatus(200);
        $response->assertSee('Positioning Theory');
        $response->assertSee('Course Progress');
    }

    public function test_toggle_lesson_progress_updates_percentage(): void
    {
        /** @var LmsService $lms */
        $lms = app(LmsService::class);
        $enrollment = $lms->enroll($this->memberUser, $this->course, 'free');

        $result = $lms->toggleLessonCompletion($enrollment, $this->lesson1);

        $this->assertTrue($result['is_completed']);
        $this->assertEquals(50.00, $result['progress_percentage']);

        $this->assertDatabaseHas('lesson_progress', [
            'enrollment_id' => $enrollment->id,
            'lesson_id' => $this->lesson1->id,
            'is_completed' => true,
        ]);
    }

    public function test_quiz_attempt_scoring_and_certificate_minting(): void
    {
        /** @var LmsService $lms */
        $lms = app(LmsService::class);
        $enrollment = $lms->enroll($this->memberUser, $this->course, 'free');

        // Complete both lessons
        $lms->toggleLessonCompletion($enrollment, $this->lesson1);
        $lms->toggleLessonCompletion($enrollment, $this->lesson2);

        $this->assertEquals(100.00, (float) $enrollment->fresh()->progress_percentage);

        // Submit quiz attempt with correct answer
        $question = $this->quiz->questions->first();
        $correctOption = $question->options->where('is_correct', true)->first();

        $attempt = $lms->submitQuizAttempt($enrollment, $this->quiz, [
            $question->id => $correctOption->id,
        ]);

        $this->assertTrue($attempt->passed);
        $this->assertEquals(100.00, (float) $attempt->percentage);

        // Verify that certificate is minted
        $enrollment->refresh();
        $this->assertNotNull($enrollment->certificate_id);
        $this->assertDatabaseHas('certificates', [
            'id' => $enrollment->certificate_id,
            'recipient_email' => $this->memberUser->email,
        ]);
    }

    public function test_public_webinar_listing_and_rsvp_registration(): void
    {
        $response = $this->get(route('webinars.index'));
        $response->assertStatus(200);
        $response->assertSee('African Brand Architecture 2026');

        $rsvpResponse = $this->post(route('webinars.register', $this->webinar->slug), [
            'first_name' => 'Tunde',
            'last_name' => 'Bakare',
            'email' => 'tunde.b@example.com',
            'phone' => '+2348001112233',
            'organization' => 'Apex Brands',
        ]);

        $rsvpResponse->assertRedirect(route('webinars.show', $this->webinar->slug));

        $this->assertDatabaseHas('webinar_registrations', [
            'webinar_id' => $this->webinar->id,
            'email' => 'tunde.b@example.com',
        ]);
    }

    public function test_webinar_ics_calendar_download(): void
    {
        $response = $this->get(route('webinars.calendar', $this->webinar->slug));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/calendar; charset=utf-8');
        $this->assertStringContainsString('BEGIN:VCALENDAR', $response->getContent());
        $this->assertStringContainsString('SUMMARY:African Brand Architecture 2026', $response->getContent());
    }

    public function test_admin_can_manage_courses_and_modules(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.lms.courses'));
        $response->assertStatus(200);
        $response->assertSee('Brand Strategy & Identity Mastery');

        // Test creating module
        $modResponse = $this->actingAs($this->admin)
            ->post(route('admin.lms.modules.store', $this->course->id), [
                'title' => 'Module 2: Trademark Strategy',
                'description' => 'Legal IP considerations.',
            ]);

        $modResponse->assertSessionHas('success');
        $this->assertDatabaseHas('course_modules', [
            'course_id' => $this->course->id,
            'title' => 'Module 2: Trademark Strategy',
        ]);
    }
}
