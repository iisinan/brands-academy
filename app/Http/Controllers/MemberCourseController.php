<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseLesson;
use App\Models\CourseResource;
use App\Models\InstructorSchedule;
use App\Models\LessonNote;
use App\Models\OfficeHourBooking;
use App\Models\Quiz;
use App\Services\LmsService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MemberCourseController extends Controller
{
    public function __construct(
        protected LmsService $lmsService
    ) {}

    /**
     * Display student enrolled courses dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $enrollments = CourseEnrollment::where('user_id', $user->id)
            ->with(['course.modules.lessons', 'certificate'])
            ->latest()
            ->get();

        return view('membership.courses.index', compact('enrollments'));
    }

    /**
     * Interactive LMS Classroom Player.
     */
    public function learn(Request $request, string $slug): View|RedirectResponse
    {
        $user = $request->user();

        $course = Course::where('slug', $slug)
            ->with([
                'modules' => fn ($q) => $q->orderBy('sort_order'),
                'modules.lessons' => fn ($q) => $q->orderBy('sort_order'),
                'resources' => fn ($q) => $q->orderBy('sort_order'),
                'quizzes.questions.options',
                'instructorSchedules' => fn ($q) => $q->where('is_active', true),
            ])
            ->firstOrFail();

        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->with(['certificate', 'lessonProgress', 'quizAttempts.quiz'])
            ->first();

        // If not enrolled and course is free, auto-enroll
        if (! $enrollment && ($course->fee_type === 'free' || $course->calculateTuitionFor($user) <= 0)) {
            $enrollment = $this->lmsService->enroll($user, $course, gateway: 'free');
        } elseif (! $enrollment) {
            return redirect()->route('courses.show', $course->slug)
                ->with('warning', 'Please enroll in this course to access the classroom materials.');
        }

        // Determine current lesson
        $lessonSlug = $request->query('lesson');
        $currentLesson = null;

        if ($lessonSlug) {
            $currentLesson = CourseLesson::where('slug', $lessonSlug)
                ->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
                ->first();
        }

        if (! $currentLesson) {
            // Find first uncompleted lesson, or the first lesson in the course
            $completedLessonIds = $enrollment->lessonProgress()
                ->where('is_completed', true)
                ->pluck('lesson_id')
                ->toArray();

            foreach ($course->modules as $mod) {
                foreach ($mod->lessons as $les) {
                    if (! in_array($les->id, $completedLessonIds, true)) {
                        $currentLesson = $les;
                        break 2;
                    }
                }
            }

            if (! $currentLesson && $course->modules->isNotEmpty() && $course->modules->first()->lessons->isNotEmpty()) {
                $currentLesson = $course->modules->first()->lessons->first();
            }
        }

        // Find next and previous lessons for navigation
        $allLessons = $course->modules->flatMap->lessons;
        $currentIndex = $allLessons->search(fn ($l) => $l->id === $currentLesson?->id);
        $prevLesson = ($currentIndex !== false && $currentIndex > 0) ? $allLessons->get($currentIndex - 1) : null;
        $nextLesson = ($currentIndex !== false && $currentIndex < $allLessons->count() - 1) ? $allLessons->get($currentIndex + 1) : null;

        $completedLessonIds = $enrollment->lessonProgress()
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        // Active tab: 'overview', 'resources', 'office_hours', 'quizzes'
        $activeTab = $request->query('tab', 'overview');

        $currentLessonNote = $currentLesson
            ? LessonNote::where('lesson_id', $currentLesson->id)->where('user_id', $user->id)->first()
            : null;

        return view('membership.courses.learn', compact(
            'course',
            'enrollment',
            'currentLesson',
            'prevLesson',
            'nextLesson',
            'completedLessonIds',
            'activeTab',
            'currentLessonNote'
        ));
    }

    /**
     * Mark a lesson as complete or incomplete.
     */
    public function toggleLesson(Request $request, string $slug, int $lessonId): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $course = Course::where('slug', $slug)->firstOrFail();
        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lesson = CourseLesson::where('id', $lessonId)
            ->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
            ->firstOrFail();

        $result = $this->lmsService->toggleLessonCompletion($enrollment, $lesson);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_completed' => $result['is_completed'],
                'progress_percentage' => $result['progress_percentage'],
                'is_course_completed' => $result['is_course_completed'],
                'certificate_url' => $result['certificate'] ? route('verify.certificate', $result['certificate']->verification_token) : null,
            ]);
        }

        return back()->with('success', $result['is_completed'] ? 'Lesson marked as complete!' : 'Lesson marked as incomplete.');
    }

    /**
     * Submit a timed quiz attempt.
     */
    public function submitQuiz(Request $request, string $slug, int $quizId): RedirectResponse
    {
        $user = $request->user();

        $course = Course::where('slug', $slug)->firstOrFail();
        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $quiz = Quiz::where('id', $quizId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $submittedAnswers = $request->input('answers', []); // [question_id => option_id]

        $attempt = $this->lmsService->submitQuizAttempt($enrollment, $quiz, $submittedAnswers);

        $statusMsg = $attempt->passed
            ? "Congratulations! You passed the quiz with {$attempt->percentage}%."
            : "You scored {$attempt->percentage}%. The passing threshold is {$quiz->pass_percentage}%. You have {$quiz->remainingAttemptsFor($user, $enrollment)} attempts remaining.";

        return redirect()->route('member.courses.learn', [
            'slug' => $course->slug,
            'tab' => 'quizzes',
        ])->with($attempt->passed ? 'success' : 'warning', $statusMsg);
    }

    /**
     * Book an Instructor Office Hours consultation slot.
     */
    public function bookOfficeHours(Request $request, string $slug): RedirectResponse
    {
        $request->validate([
            'instructor_schedule_id' => 'required|exists:instructor_schedules,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|string',
            'topic' => 'nullable|string|max:500',
        ]);

        $user = $request->user();
        $course = Course::where('slug', $slug)->firstOrFail();
        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $schedule = InstructorSchedule::where('id', $request->input('instructor_schedule_id'))
            ->where('course_id', $course->id)
            ->firstOrFail();

        $startTime = $request->input('start_time');
        $startCarbon = Carbon::createFromFormat('H:i', $startTime);
        $endTime = $startCarbon->copy()->addMinutes($schedule->slot_duration_minutes)->format('H:i');

        OfficeHourBooking::create([
            'instructor_schedule_id' => $schedule->id,
            'user_id' => $user->id,
            'enrollment_id' => $enrollment->id,
            'booking_date' => $request->input('booking_date'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'topic' => $request->input('topic'),
            'meeting_link' => $schedule->meeting_link ?: $course->meeting_link,
            'status' => 'confirmed',
        ]);

        return redirect()->route('member.courses.learn', [
            'slug' => $course->slug,
            'tab' => 'office_hours',
        ])->with('success', 'Office hours consultation successfully scheduled! Your Google Meet session details are confirmed.');
    }

    /**
     * Download a course resource attachment.
     */
    public function downloadResource(Request $request, string $slug, int $resourceId): BinaryFileResponse|RedirectResponse
    {
        $user = $request->user();
        $course = Course::where('slug', $slug)->firstOrFail();

        // Verify enrollment or admin
        $isEnrolled = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists() || $user->isAdmin();

        if (! $isEnrolled) {
            return back()->with('error', 'You must be enrolled to download course materials.');
        }

        $resource = CourseResource::where('id', $resourceId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        if ($resource->external_url) {
            $resource->increment('download_count');

            return redirect()->away($resource->external_url);
        }

        if (! empty($resource->file_path) && file_exists(storage_path('app/public/'.$resource->file_path))) {
            $resource->increment('download_count');

            return response()->download(storage_path('app/public/'.$resource->file_path), $resource->file_name ?? $resource->title);
        }

        return back()->with('info', 'This resource is available as an external guide.');
    }

    /**
     * Save student notes on a specific lesson.
     */
    public function saveNote(Request $request, string $slug, int $lessonId): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        $course = Course::where('slug', $slug)->firstOrFail();
        $lesson = CourseLesson::where('id', $lessonId)
            ->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
            ->firstOrFail();

        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:10000'],
        ]);

        $note = LessonNote::updateOrCreate(
            [
                'lesson_id' => $lesson->id,
                'user_id' => $user->id,
            ],
            [
                'notes' => $validated['notes'],
            ]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notes saved successfully.',
                'note' => $note,
            ]);
        }

        return back()->with('success', 'Your study notes have been saved.');
    }
}
