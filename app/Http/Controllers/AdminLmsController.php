<?php

namespace App\Http\Controllers;

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
use App\Services\Video\GoogleMeetDriver;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminLmsController extends Controller
{
    /**
     * Admin Courses Listing.
     */
    public function courses(Request $request): View
    {
        $courses = Course::withCount(['modules', 'lessons', 'enrollments'])
            ->latest()
            ->paginate(12);

        return view('admin.lms.courses.index', compact('courses'));
    }

    /**
     * Create Course Form.
     */
    public function createCourse(): View
    {
        return view('admin.lms.courses.create');
    }

    /**
     * Store New Course.
     */
    public function storeCourse(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'track' => 'required|string|max:100',
            'delivery_mode' => 'required|in:self_paced,live_cohort,hybrid',
            'fee_type' => 'required|in:free,paid',
            'regular_price' => 'nullable|numeric|min:0',
            'member_price' => 'nullable|numeric|min:0',
            'meeting_provider' => 'required|in:google_meet,zoom,youtube_live',
            'meeting_link' => 'nullable|string|max:500',
            'instructor_name' => 'nullable|string|max:150',
            'instructor_title' => 'nullable|string|max:150',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'duration_weeks' => 'nullable|integer|min:1',
            'estimated_hours' => 'nullable|integer|min:1',
            'level' => 'required|string|max:50',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        if (($validated['fee_type'] ?? '') === 'paid' && empty($validated['regular_price'])) {
            $validated['regular_price'] = 20000;
        }

        // Auto-generate Google Meet room if none provided
        if (empty($validated['meeting_link']) && $validated['meeting_provider'] === 'google_meet') {
            $meetDriver = new GoogleMeetDriver;
            $meetData = $meetDriver->createMeeting(['title' => $validated['title']]);
            $validated['meeting_link'] = $meetData['join_url'];
        }

        $course = Course::create($validated);

        return redirect()->route('admin.lms.courses.edit', $course->id)
            ->with('success', 'Course created! Now you can structure modules, lessons, quizzes, and resources.');
    }

    /**
     * Edit Course & Full Curriculum Builder.
     */
    public function editCourse(int $id): View
    {
        $course = Course::with([
            'modules.lessons',
            'resources',
            'quizzes.questions.options',
            'instructorSchedules.instructor',
            'enrollments.user',
        ])->findOrFail($id);

        $instructors = User::whereIn('role', ['admin', 'member'])->get();

        return view('admin.lms.courses.edit', compact('course', 'instructors'));
    }

    /**
     * Update Course Metadata.
     */
    public function updateCourse(Request $request, int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'track' => 'required|string|max:100',
            'delivery_mode' => 'required|in:self_paced,live_cohort,hybrid',
            'fee_type' => 'required|in:free,paid',
            'regular_price' => 'nullable|numeric|min:0',
            'member_price' => 'nullable|numeric|min:0',
            'meeting_provider' => 'required|in:google_meet,zoom,youtube_live',
            'meeting_link' => 'nullable|string|max:500',
            'instructor_name' => 'nullable|string|max:150',
            'instructor_title' => 'nullable|string|max:150',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'duration_weeks' => 'nullable|integer|min:1',
            'estimated_hours' => 'nullable|integer|min:1',
            'level' => 'required|string|max:50',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        $course->update($validated);

        return back()->with('success', 'Course updated successfully.');
    }

    /**
     * Delete Course.
     */
    public function destroyCourse(int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.lms.courses')->with('success', 'Course deleted.');
    }

    /**
     * Add Module.
     */
    public function storeModule(Request $request, int $courseId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['course_id'] = $course->id;
        $validated['sort_order'] = $validated['sort_order'] ?? ($course->modules()->count() + 1);

        CourseModule::create($validated);

        return back()->with('success', 'Module added successfully.');
    }

    /**
     * Delete Module.
     */
    public function destroyModule(int $courseId, int $moduleId): RedirectResponse
    {
        $module = CourseModule::where('id', $moduleId)->where('course_id', $courseId)->firstOrFail();
        $module->delete();

        return back()->with('success', 'Module and its lessons removed.');
    }

    /**
     * Add Lesson to Module.
     */
    public function storeLesson(Request $request, int $courseId, int $moduleId): RedirectResponse
    {
        $module = CourseModule::where('id', $moduleId)->where('course_id', $courseId)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_type' => 'required|in:video,reading,live_session,quiz',
            'video_provider' => 'required|in:youtube_unlisted,vimeo,direct_url',
            'video_id_or_url' => 'nullable|string|max:500',
            'body_text' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'meeting_link' => 'nullable|string|max:500',
            'is_free_preview' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['course_module_id'] = $module->id;
        $validated['is_free_preview'] = $request->boolean('is_free_preview', false);
        $validated['sort_order'] = $validated['sort_order'] ?? ($module->lessons()->count() + 1);

        CourseLesson::create($validated);

        return back()->with('success', 'Lesson added to module.');
    }

    /**
     * Delete Lesson.
     */
    public function destroyLesson(int $courseId, int $lessonId): RedirectResponse
    {
        $lesson = CourseLesson::where('id', $lessonId)
            ->whereHas('module', fn ($q) => $q->where('course_id', $courseId))
            ->firstOrFail();

        $lesson->delete();

        return back()->with('success', 'Lesson deleted.');
    }

    /**
     * Add Quiz to Course.
     */
    public function storeQuiz(Request $request, int $courseId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit_minutes' => 'required|integer|min:1|max:180',
            'pass_percentage' => 'required|integer|min:1|max:100',
            'max_attempts' => 'required|integer|min:1|max:20',
            'course_module_id' => 'nullable|exists:course_modules,id',
            'is_required_for_certificate' => 'nullable|boolean',
        ]);

        $validated['course_id'] = $course->id;
        $validated['is_required_for_certificate'] = $request->boolean('is_required_for_certificate', true);
        $validated['is_published'] = true;

        Quiz::create($validated);

        return back()->with('success', 'Quiz created! Now add multiple-choice questions.');
    }

    /**
     * Add Question with Options to Quiz.
     */
    public function storeQuizQuestion(Request $request, int $quizId): RedirectResponse
    {
        $quiz = Quiz::findOrFail($quizId);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'correct_option_index' => 'required|integer',
        ]);

        $question = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question_text' => $validated['question_text'],
            'explanation' => $validated['explanation'] ?? null,
            'points' => $validated['points'],
            'sort_order' => $quiz->questions()->count() + 1,
        ]);

        $correctIndex = (int) $validated['correct_option_index'];

        foreach ($validated['options'] as $idx => $opt) {
            QuizOption::create([
                'quiz_question_id' => $question->id,
                'option_text' => $opt['text'],
                'is_correct' => $idx === $correctIndex,
                'sort_order' => $idx + 1,
            ]);
        }

        return back()->with('success', 'Question with options added to quiz.');
    }

    /**
     * Delete Quiz.
     */
    public function destroyQuiz(int $quizId): RedirectResponse
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->delete();

        return back()->with('success', 'Quiz deleted.');
    }

    /**
     * Store Course Resource / Attachment.
     */
    public function storeResource(Request $request, int $courseId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'file_type' => 'required|in:pdf,slides,template,sheet,zip,link',
            'external_url' => 'nullable|string|max:500',
            'course_module_id' => 'nullable|exists:course_modules,id',
            'attachment' => 'nullable|file|max:20480', // 20MB max
        ]);

        $filePath = null;
        $fileName = null;
        $fileSize = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('course_resources', 'public');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
        }

        CourseResource::create([
            'course_id' => $course->id,
            'course_module_id' => $validated['course_module_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'file_type' => $validated['file_type'],
            'external_url' => $validated['external_url'] ?? null,
            'sort_order' => $course->resources()->count() + 1,
        ]);

        return back()->with('success', 'Resource material attached to course.');
    }

    /**
     * Delete Resource.
     */
    public function destroyResource(int $resourceId): RedirectResponse
    {
        $resource = CourseResource::findOrFail($resourceId);
        $resource->delete();

        return back()->with('success', 'Resource material removed.');
    }

    /**
     * Add Instructor Office Hours Schedule.
     */
    public function storeInstructorSchedule(Request $request, int $courseId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'instructor_user_id' => 'required|exists:users,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'slot_duration_minutes' => 'required|integer|min:10|max:120',
            'meeting_provider' => 'required|in:google_meet,zoom',
            'meeting_link' => 'nullable|string|max:500',
        ]);

        $validated['course_id'] = $course->id;
        $validated['is_active'] = true;

        if (empty($validated['meeting_link']) && $validated['meeting_provider'] === 'google_meet') {
            $meetDriver = new GoogleMeetDriver;
            $meetData = $meetDriver->createMeeting(['title' => 'Office Hours - '.$course->title]);
            $validated['meeting_link'] = $meetData['join_url'];
        }

        InstructorSchedule::create($validated);

        return back()->with('success', 'Instructor office hours schedule activated.');
    }

    /**
     * Delete Instructor Schedule.
     */
    public function destroyInstructorSchedule(int $scheduleId): RedirectResponse
    {
        $schedule = InstructorSchedule::findOrFail($scheduleId);
        $schedule->delete();

        return back()->with('success', 'Office hours schedule removed.');
    }

    /**
     * Admin Webinars Management.
     */
    public function webinars(): View
    {
        $webinars = Webinar::withCount('registrations')
            ->latest('starts_at')
            ->paginate(15);

        return view('admin.lms.webinars.index', compact('webinars'));
    }

    /**
     * Store Webinar.
     */
    public function storeWebinar(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'speaker_name' => 'required|string|max:150',
            'speaker_title' => 'nullable|string|max:150',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'starts_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:240',
            'fee_type' => 'required|in:free,paid',
            'regular_price' => 'nullable|numeric|min:0',
            'member_price' => 'nullable|numeric|min:0',
            'meeting_provider' => 'required|in:google_meet,zoom,youtube_live',
            'meeting_link' => 'nullable|string|max:500',
            'recording_url' => 'nullable|string|max:500',
        ]);

        $validated['is_published'] = $request->boolean('is_published', true);

        if (empty($validated['meeting_link']) && $validated['meeting_provider'] === 'google_meet') {
            $meetDriver = new GoogleMeetDriver;
            $meetData = $meetDriver->createMeeting(['title' => $validated['title']]);
            $validated['meeting_link'] = $meetData['join_url'];
        }

        Webinar::create($validated);

        return back()->with('success', 'Webinar scheduled with Google Meet integration.');
    }

    /**
     * Update Webinar.
     */
    public function updateWebinar(Request $request, int $id): RedirectResponse
    {
        $webinar = Webinar::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'speaker_name' => 'required|string|max:150',
            'speaker_title' => 'nullable|string|max:150',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'starts_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:240',
            'meeting_provider' => 'required|in:google_meet,zoom,youtube_live',
            'meeting_link' => 'nullable|string|max:500',
            'recording_url' => 'nullable|string|max:500',
            'status' => 'required|in:upcoming,live,concluded,cancelled',
        ]);

        $webinar->update($validated);

        return back()->with('success', 'Webinar updated.');
    }

    /**
     * Delete Webinar.
     */
    public function destroyWebinar(int $id): RedirectResponse
    {
        $webinar = Webinar::findOrFail($id);
        $webinar->delete();

        return back()->with('success', 'Webinar deleted.');
    }

    /**
     * Export Webinar Registrations CSV.
     */
    public function exportWebinarAttendees(int $id): StreamedResponse
    {
        $webinar = Webinar::with('registrations')->findOrFail($id);

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="webinar-'.$webinar->slug.'-attendees.csv"',
        ];

        return response()->stream(function () use ($webinar): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Token', 'First Name', 'Last Name', 'Email', 'Phone', 'Organization', 'Amount Paid', 'Attended', 'Registered At']);

            foreach ($webinar->registrations as $reg) {
                fputcsv($handle, [
                    $reg->id,
                    $reg->token,
                    $reg->first_name,
                    $reg->last_name,
                    $reg->email,
                    $reg->phone ?? 'N/A',
                    $reg->organization ?? 'N/A',
                    $reg->amount_paid,
                    $reg->attended ? 'Yes' : 'No',
                    $reg->created_at->toDateTimeString(),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
