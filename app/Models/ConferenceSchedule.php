<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConferenceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id',
        'day_number',
        'day_date',
        'start_time',
        'end_time',
        'session_title',
        'session_description',
        'speaker_name',
        'speaker_role',
        'hall_or_stream',
        'track_type',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'day_number' => 'integer',
            'day_date' => 'date',
            'sort_order' => 'integer',
        ];
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }
}
