<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseLesson;
use App\Models\LessonProgress;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LmsService
{
    /**
     * Enroll a user into a course.
     */
    public function enroll(
        User $user,
        Course $course,
        string $gateway = 'free',
        ?string $reference = null,
        float $amountPaid = 0.0
    ): CourseEnrollment {
        $member = $user->member;

        return CourseEnrollment::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'member_id' => $member?->id,
                'status' => 'active',
                'amount_paid' => $amountPaid,
                'payment_gateway' => $gateway,
                'payment_reference' => $reference,
                'progress_percentage' => 0.0,
            ]
        );
    }

    /**
     * Toggle lesson completion for an enrolled student.
     *
     * @return array{is_completed: bool, progress_percentage: float, is_course_completed: bool, certificate: ?Certificate}
     */
    public function toggleLessonCompletion(CourseEnrollment $enrollment, CourseLesson $lesson): array
    {
        $progress = LessonProgress::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($progress && $progress->is_completed) {
            $progress->update([
                'is_completed' => false,
                'completed_at' => null,
            ]);
            $isCompleted = false;
        } else {
            LessonProgress::updateOrCreate(
                [
                    'enrollment_id' => $enrollment->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'is_completed' => true,
                    'completed_at' => Carbon::now(),
                ]
            );
            $isCompleted = true;
        }

        $percentage = $enrollment->recalculateProgress();
        $certificate = null;

        if ($enrollment->status === 'completed' && ! $enrollment->certificate_id) {
            $certificate = $this->autoMintCourseCertificate($enrollment);
        }

        return [
            'is_completed' => $isCompleted,
            'progress_percentage' => $percentage,
            'is_course_completed' => $enrollment->status === 'completed',
            'certificate' => $certificate ?? $enrollment->certificate,
        ];
    }

    /**
     * Submit and grade a timed quiz attempt.
     *
     * @param  array<int, int>  $submittedAnswers  Map of question_id => selected_option_id
     */
    public function submitQuizAttempt(CourseEnrollment $enrollment, Quiz $quiz, array $submittedAnswers): QuizAttempt
    {
        $quiz->loadMissing(['questions.options']);

        $totalPoints = 0;
        $earnedScore = 0;

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            $selectedOptionId = $submittedAnswers[$question->id] ?? null;

            if ($selectedOptionId) {
                $isCorrect = $question->options
                    ->where('id', $selectedOptionId)
                    ->where('is_correct', true)
                    ->isNotEmpty();

                if ($isCorrect) {
                    $earnedScore += $question->points;
                }
            }
        }

        $percentage = $totalPoints > 0 ? round(($earnedScore / $totalPoints) * 100, 2) : 100.0;
        $passed = $percentage >= $quiz->pass_percentage;

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $enrollment->user_id,
            'enrollment_id' => $enrollment->id,
            'score' => $earnedScore,
            'total_points' => $totalPoints,
            'percentage' => $percentage,
            'passed' => $passed,
            'answers' => $submittedAnswers,
            'started_at' => Carbon::now()->subMinutes($quiz->time_limit_minutes),
            'submitted_at' => Carbon::now(),
        ]);

        // Recheck enrollment completion eligibility
        $enrollment->recalculateProgress();
        if ($enrollment->status === 'completed' && ! $enrollment->certificate_id) {
            $this->autoMintCourseCertificate($enrollment);
        }

        return $attempt;
    }

    /**
     * Automatically mint and attach a verifiable certificate when course requirements are satisfied.
     */
    public function autoMintCourseCertificate(CourseEnrollment $enrollment): ?Certificate
    {
        if ($enrollment->certificate_id) {
            return $enrollment->certificate;
        }

        $course = $enrollment->course;
        $user = $enrollment->user;
        $member = $enrollment->member ?: $user->member;

        $certificateNumber = 'BANF-LMS-'.date('Y').'-'.strtoupper(Str::random(6));
        $verificationToken = 'BANF-'.strtoupper(Str::random(12));

        $certificate = Certificate::create([
            'certificate_number' => $certificateNumber,
            'verification_token' => $verificationToken,
            'course_id' => $course->id,
            'workshop_id' => null,
            'workshop_application_id' => null,
            'member_id' => $member?->id,
            'recipient_name' => $member ? $member->full_name : $user->name,
            'recipient_email' => $user->email,
            'course_title' => $course->title,
            'track_tier' => 'Executive Short Course (LMS)',
            'issued_at' => Carbon::now()->toDateString(),
            'email_status' => 'issued',
        ]);

        $enrollment->update([
            'certificate_id' => $certificate->id,
        ]);

        return $certificate;
    }
}
