<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebinarQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'webinar_id',
        'user_id',
        'attendee_name',
        'attendee_organization',
        'question',
        'upvotes_count',
        'is_answered',
    ];

    protected function casts(): array
    {
        return [
            'upvotes_count' => 'integer',
            'is_answered' => 'boolean',
        ];
    }

    public function webinar(): BelongsTo
    {
        return $this->belongsTo(Webinar::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
