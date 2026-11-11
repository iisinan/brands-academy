<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class ForumThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id',
        'user_id',
        'title',
        'slug',
        'body',
        'is_pinned',
        'is_locked',
        'views_count',
        'replies_count',
        'likes_count',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
            'views_count' => 'integer',
            'replies_count' => 'integer',
            'likes_count' => 'integer',
            'last_activity_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ForumThread $thread): void {
            if (empty($thread->slug)) {
                $base = Str::slug($thread->title);
                $thread->slug = $base.'-'.Str::lower(Str::random(5));
            }

            if (empty($thread->last_activity_at)) {
                $thread->last_activity_at = now();
            }
        });
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(ForumChannel::class, 'channel_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'thread_id')->oldest();
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(ForumReaction::class, 'reactable');
    }

    public function isLikedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->reactions()->where('user_id', $user->id)->exists();
    }

    public function hasAcceptedAnswer(): bool
    {
        return $this->replies()->where('is_accepted_answer', true)->exists();
    }
}
