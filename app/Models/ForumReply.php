<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'parent_reply_id',
        'body',
        'is_accepted_answer',
        'likes_count',
    ];

    protected function casts(): array
    {
        return [
            'is_accepted_answer' => 'boolean',
            'likes_count' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (ForumReply $reply): void {
            $reply->thread->increment('replies_count');
            $reply->thread->update(['last_activity_at' => now()]);
        });

        static::deleted(function (ForumReply $reply): void {
            $reply->thread->decrement('replies_count');
        });
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ForumReply::class, 'parent_reply_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'parent_reply_id')->oldest();
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
}
