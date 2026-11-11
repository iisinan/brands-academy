<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseReview;
use App\Services\LmsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function __construct(
        protected LmsService $lmsService
    ) {}

    /**
     * Public Courses Catalog.
     */
    public function index(Request $request): View
    {
        $track = $request->query('track');
        $mode = $request->query('mode');
        $search = $request->query('q');

        $query = Course::query()
            ->where('is_published', true)
            ->withCount(['modules', 'lessons']);

        if (! empty($track) && $track !== 'all') {
            $query->where('track', $track);
        }

        if (! empty($mode) && $mode !== 'all') {
            $query->where('delivery_mode', $mode);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('is_featured', 'desc')
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(9)
            ->withQueryString();

        $featuredCourse = Course::where('is_published', true)
            ->where('is_featured', true)
            ->withCount(['modules', 'lessons'])
            ->first();

        $tracks = Course::where('is_published', true)
            ->distinct()
            ->pluck('track');

        return view('courses.index', compact('courses', 'featuredCourse', 'tracks', 'track', 'mode', 'search'));
    }

    /**
     * Public Course Detail & Syllabus Outline.
     */
    public function show(Request $request, string $slug): View
    {
        $course = Course::where('slug', $slug)
            ->where('is_published', true)
            ->with([
                'modules.lessons',
                'resources',
                'quizzes' => fn ($q) => $q->where('is_published', true),
                'instructorSchedules' => fn ($q) => $q->where('is_active', true),
                'reviews.user',
            ])
            ->firstOrFail();

        $user = $request->user();
        $isEnrolled = false;
        $enrollment = null;
        $userReview = null;

        if ($user) {
            $enrollment = CourseEnrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();
            $isEnrolled = (bool) $enrollment;
            $userReview = CourseReview::where('course_id', $course->id)
                ->where('user_id', $user->id)
                ->first();
        }

        $tuition = $course->calculateTuitionFor($user);
        $isDiscounted = $user && ($user->isMember() || $user->isAdmin()) && $course->fee_type !== 'free' && $course->regular_price > $tuition;

        return view('courses.show', compact('course', 'isEnrolled', 'enrollment', 'tuition', 'isDiscounted', 'userReview'));
    }

    /**
     * Course Enrollment / Checkout Handler.
     */
    public function enroll(Request $request, string $slug): RedirectResponse
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->guest(route('login'))->with('info', 'Please sign in or create an account to enroll in this course.');
        }

        $course = Course::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Check if already enrolled
        $existingEnrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('member.courses.learn', $course->slug)
                ->with('info', 'You are already enrolled in this course.');
        }

        $tuition = $course->calculateTuitionFor($user);

        // If tuition is free, enroll directly
        if ($tuition <= 0) {
            $this->lmsService->enroll($user, $course, gateway: 'free', amountPaid: 0.0);

            return redirect()->route('member.courses.learn', $course->slug)
                ->with('success', 'Enrollment successful! Welcome to the classroom.');
        }

        // Initialize Online Payment via Paystack
        $secretKey = config('membership.paystack.secret_key');
        $reference = 'COURSE-'.strtoupper(Str::random(12));

        if (empty($secretKey)) {
            // Local fallback / sandbox auto-enrollment
            $this->lmsService->enroll(
                $user,
                $course,
                gateway: 'paystack_simulated',
                reference: $reference,
                amountPaid: $tuition
            );

            return redirect()->route('member.courses.learn', $course->slug)
                ->with('success', 'Payment verified! You are now enrolled in '.$course->title);
        }

        // Initialize real Paystack transaction
        try {
            $callbackUrl = route('courses.callback', $course->slug);

            $response = Http::withToken($secretKey)
                ->timeout(15)
                ->post('https://api.paystack.co/transaction/initialize', [
                    'email' => $user->email,
                    'amount' => (int) round($tuition * 100),
                    'reference' => $reference,
                    'callback_url' => $callbackUrl,
                    'metadata' => [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                        'tuition_paid' => $tuition,
                    ],
                ]);

            if ($response->successful() && $response->json('status')) {
                $authUrl = $response->json('data.authorization_url');

                return redirect()->away($authUrl);
            }

            Log::error('Paystack Course Init Failed', ['response' => $response->json()]);

            return back()->with('error', 'Could not initiate online payment gateway. Please try again.');
        } catch (\Throwable $e) {
            Log::error('Paystack Course Exception', ['error' => $e->getMessage()]);

            return back()->with('error', 'Payment gateway connection error: '.$e->getMessage());
        }
    }

    /**
     * Paystack Callback for Course Enrollment.
     */
    public function callback(Request $request, string $slug): RedirectResponse
    {
        $reference = $request->query('reference');
        $user = $request->user();

        if (! $reference) {
            return redirect()->route('courses.show', $slug)->with('error', 'Invalid payment reference.');
        }

        $course = Course::where('slug', $slug)->firstOrFail();
        $secretKey = config('membership.paystack.secret_key');

        if (! empty($secretKey)) {
            try {
                $verifyResponse = Http::withToken($secretKey)
                    ->timeout(15)
                    ->get("https://api.paystack.co/transaction/verify/{$reference}");

                if (! $verifyResponse->successful() || $verifyResponse->json('data.status') !== 'success') {
                    return redirect()->route('courses.show', $slug)->with('error', 'Payment could not be verified.');
                }
            } catch (\Throwable $e) {
                Log::error('Course verify exception', ['error' => $e->getMessage()]);
            }
        }

        if ($user) {
            $this->lmsService->enroll(
                $user,
                $course,
                gateway: 'paystack',
                reference: $reference,
                amountPaid: $course->calculateTuitionFor($user)
            );
        }

        return redirect()->route('member.courses.learn', $course->slug)
            ->with('success', 'Payment confirmed! Welcome to '.$course->title);
    }

    /**
     * Store student review & star rating for a course.
     */
    public function storeReview(Request $request, string $slug): RedirectResponse
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $user = $request->user();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'title' => ['nullable', 'string', 'max:150'],
            'comment' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $isEnrolled = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();

        CourseReview::updateOrCreate(
            [
                'course_id' => $course->id,
                'user_id' => $user->id,
            ],
            [
                'rating' => $validated['rating'],
                'title' => $validated['title'] ?? null,
                'comment' => $validated['comment'],
                'is_verified_learner' => $isEnrolled,
                'is_published' => true,
            ]
        );

        return back()->with('success', 'Thank you! Your course evaluation has been published.');
    }
}
