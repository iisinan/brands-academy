<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseEnrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'member_id',
        'course_id',
        'status',
        'amount_paid',
        'payment_gateway',
        'payment_reference',
        'progress_percentage',
        'completed_at',
        'certificate_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'progress_percentage' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Enrolled user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Associated member profile.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Enrolled course.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Certificate awarded upon completion.
     */
    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }

    /**
     * Lesson progress records.
     */
    public function lessonProgress(): HasMany
    {
        return $this->hasMany(LessonProgress::class, 'enrollment_id');
    }

    /**
     * Quiz attempts made in this enrollment.
     */
    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'enrollment_id');
    }

    /**
     * Office hour bookings.
     */
    public function officeHourBookings(): HasMany
    {
        return $this->hasMany(OfficeHourBooking::class, 'enrollment_id');
    }

    /**
     * Check if enrollment has passed all required quizzes for the course.
     */
    public function hasPassedRequiredQuizzes(): bool
    {
        $requiredQuizIds = $this->course->quizzes()
            ->where('is_required_for_certificate', true)
            ->where('is_published', true)
            ->pluck('id');

        if ($requiredQuizIds->isEmpty()) {
            return true;
        }

        foreach ($requiredQuizIds as $quizId) {
            $hasPassed = $this->quizAttempts()
                ->where('quiz_id', $quizId)
                ->where('passed', true)
                ->exists();

            if (! $hasPassed) {
                return false;
            }
        }

        return true;
    }

    /**
     * Recalculate progress percentage and check if eligible for auto-completion.
     */
    public function recalculateProgress(): float
    {
        $totalLessons = $this->course->totalLessonsCount();

        if ($totalLessons === 0) {
            $percentage = 100.0;
        } else {
            $completedLessons = $this->lessonProgress()
                ->where('is_completed', true)
                ->count();
            $percentage = round(($completedLessons / $totalLessons) * 100, 2);
        }

        $this->progress_percentage = min(100.0, $percentage);

        if ($this->progress_percentage >= 100.0 && $this->hasPassedRequiredQuizzes()) {
            if ($this->status !== 'completed') {
                $this->status = 'completed';
                $this->completed_at = Carbon::now();
            }
        }

        $this->save();

        return (float) $this->progress_percentage;
    }
}
