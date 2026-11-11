<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'code',
        'track',
        'short_description',
        'description',
        'instructor_name',
        'instructor_title',
        'instructor_bio',
        'instructor_avatar',
        'delivery_mode',
        'fee_type',
        'regular_price',
        'member_price',
        'meeting_provider',
        'meeting_link',
        'meeting_instructions',
        'thumbnail',
        'duration_weeks',
        'estimated_hours',
        'level',
        'is_published',
        'is_featured',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'regular_price' => 'decimal:2',
            'member_price' => 'decimal:2',
            'duration_weeks' => 'integer',
            'estimated_hours' => 'integer',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Booted method to handle slug generation and member price calculation.
     */
    protected static function booted(): void
    {
        static::creating(function (Course $course): void {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title).'-'.Str::random(5);
            }
            if ($course->fee_type === 'free') {
                $course->regular_price = 0;
                $course->member_price = 0;
            } elseif ($course->member_price <= 0 && $course->regular_price > 0) {
                // Apply standard 25% member discount by default
                $course->member_price = round($course->regular_price * 0.75, 2);
            }
        });
    }

    /**
     * Modules belonging to this course.
     */
    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('sort_order');
    }

    /**
     * Lessons belonging to this course through modules.
     */
    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(CourseLesson::class, CourseModule::class);
    }

    /**
     * Enrollments for this course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    /**
     * Quizzes for this course.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Downloadable materials and resources.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(CourseResource::class)->orderBy('sort_order');
    }

    /**
     * Instructor office hours schedules.
     */
    public function instructorSchedules(): HasMany
    {
        return $this->hasMany(InstructorSchedule::class);
    }

    /**
     * Calculate effective tuition for a given user (25% off if verified member).
     */
    public function calculateTuitionFor(?User $user): float
    {
        if ($this->fee_type === 'free' || $this->regular_price <= 0) {
            return 0.0;
        }

        if ($user && ($user->isMember() || $user->isAdmin())) {
            return (float) ($this->member_price > 0 ? $this->member_price : round($this->regular_price * 0.75, 2));
        }

        return (float) $this->regular_price;
    }

    /**
     * Formatted tuition strings.
     */
    public function formattedRegularPrice(): string
    {
        return $this->fee_type === 'free' || $this->regular_price <= 0
            ? 'Free'
            : '₦'.number_format($this->regular_price, 2);
    }

    public function formattedMemberPrice(): string
    {
        return $this->fee_type === 'free' || $this->member_price <= 0
            ? 'Free'
            : '₦'.number_format($this->member_price, 2);
    }

    /**
     * Total lessons count across all modules.
     */
    public function totalLessonsCount(): int
    {
        return $this->lessons()->count();
    }

    /**
     * Student reviews and ratings.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(CourseReview::class)->where('is_published', true)->latest();
    }

    /**
     * Average review score.
     */
    public function averageRating(): float
    {
        return round((float) ($this->reviews()->avg('rating') ?? 5.0), 1);
    }
}
