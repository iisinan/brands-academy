<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'course_module_id',
        'title',
        'description',
        'time_limit_minutes',
        'pass_percentage',
        'max_attempts',
        'is_required_for_certificate',
        'is_published',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'time_limit_minutes' => 'integer',
            'pass_percentage' => 'integer',
            'max_attempts' => 'integer',
            'is_required_for_certificate' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Course parent.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Module parent.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

    /**
     * Questions in this quiz.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('sort_order');
    }

    /**
     * Attempts made on this quiz.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Determine if a user has passed this quiz.
     */
    public function hasPassedByUser(User $user, ?CourseEnrollment $enrollment = null): bool
    {
        $query = $this->attempts()->where('user_id', $user->id)->where('passed', true);
        if ($enrollment) {
            $query->where('enrollment_id', $enrollment->id);
        }

        return $query->exists();
    }

    /**
     * Count remaining attempts for user.
     */
    public function remainingAttemptsFor(User $user, ?CourseEnrollment $enrollment = null): int
    {
        $query = $this->attempts()->where('user_id', $user->id);
        if ($enrollment) {
            $query->where('enrollment_id', $enrollment->id);
        }

        $used = $query->count();

        return max(0, $this->max_attempts - $used);
    }
}
