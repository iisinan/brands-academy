<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CourseLesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_module_id',
        'title',
        'slug',
        'content_type',
        'video_provider',
        'video_id_or_url',
        'body_text',
        'duration_minutes',
        'meeting_link',
        'is_free_preview',
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
            'duration_minutes' => 'integer',
            'is_free_preview' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Booted method to handle slug generation.
     */
    protected static function booted(): void
    {
        static::creating(function (CourseLesson $lesson): void {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title).'-'.Str::random(4);
            }
        });
    }

    /**
     * Parent module.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

    /**
     * Progress tracks for this lesson.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class, 'lesson_id');
    }

    /**
     * Resources associated with this lesson.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(CourseResource::class, 'course_lesson_id');
    }

    /**
     * Determine if this lesson is completed by the given enrollment.
     */
    public function isCompletedBy(?CourseEnrollment $enrollment): bool
    {
        if (! $enrollment) {
            return false;
        }

        return $this->progress()
            ->where('enrollment_id', $enrollment->id)
            ->where('is_completed', true)
            ->exists();
    }

    /**
     * Format YouTube embed URL safely for unlisted/public links.
     */
    public function getYoutubeEmbedUrl(): ?string
    {
        if (empty($this->video_id_or_url)) {
            return null;
        }

        $url = $this->video_id_or_url;

        // If it's already an embed URL
        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        // Standard watch?v= or youtu.be/ regex
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            return 'https://www.youtube-nocookie.com/embed/'.$match[1].'?rel=0&modestbranding=1';
        }

        return $url;
    }

    /**
     * Student study notes on this lesson.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(LessonNote::class, 'lesson_id');
    }
}
