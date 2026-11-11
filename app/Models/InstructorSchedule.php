<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstructorSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'instructor_user_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'meeting_provider',
        'meeting_link',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'slot_duration_minutes' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Course associated.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Instructor user.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_user_id');
    }

    /**
     * Bookings made against this schedule.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(OfficeHourBooking::class);
    }

    /**
     * Formatted label (e.g. "Every Wednesday: 14:00 - 16:00 (20 min sessions)").
     */
    public function formattedLabel(): string
    {
        return ucfirst($this->day_of_week).', '.$this->start_time.' - '.$this->end_time.' ('.$this->slot_duration_minutes.' min slots)';
    }
}
