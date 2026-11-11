<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ForumChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'badge_color',
        'is_member_only',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_member_only' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ForumChannel $channel): void {
            if (empty($channel->slug)) {
                $channel->slug = Str::slug($channel->name);
            }
        });
    }

    public function threads(): HasMany
    {
        return $this->hasMany(ForumThread::class, 'channel_id');
    }
}
