<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficeHourBooking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'instructor_schedule_id',
        'user_id',
        'enrollment_id',
        'booking_date',
        'start_time',
        'end_time',
        'topic',
        'meeting_link',
        'status',
        'admin_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    /**
     * Parent schedule.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(InstructorSchedule::class, 'instructor_schedule_id');
    }

    /**
     * Booked student user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Enrollment context.
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class, 'enrollment_id');
    }
}
