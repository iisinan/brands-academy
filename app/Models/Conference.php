<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'theme',
        'year',
        'venue',
        'starts_at',
        'ends_at',
        'description',
        'keynote_speakers',
        'schedule_agenda',
        'banner_path',
        'is_active',
        'cfp_open',
        'cfp_deadline',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'cfp_deadline' => 'date',
            'keynote_speakers' => 'array',
            'schedule_agenda' => 'array',
            'is_active' => 'boolean',
            'cfp_open' => 'boolean',
            'year' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Conference $conference): void {
            if (empty($conference->slug)) {
                $conference->slug = Str::slug($conference->title.'-'.($conference->year ?: date('Y')));
            }
        });
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(ConferenceTicket::class);
    }

    public function delegates(): HasMany
    {
        return $this->hasMany(ConferenceDelegate::class);
    }

    public function papers(): HasMany
    {
        return $this->hasMany(CallForPaper::class);
    }

    public function isUpcoming(): bool
    {
        return $this->ends_at->isFuture();
    }

    public function isConcluded(): bool
    {
        return $this->ends_at->isPast();
    }

    public function getLowestPriceFor(?User $user = null): float
    {
        $isMember = $user && $user->member && $user->member->isPaid();

        $tickets = $this->tickets;
        if ($tickets->isEmpty()) {
            return 0.00;
        }

        return (float) $tickets->min(function (ConferenceTicket $t) use ($isMember) {
            return $isMember ? $t->member_price : $t->regular_price;
        });
    }

    /**
     * Agenda schedules and timetable sessions.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(ConferenceSchedule::class)->orderBy('day_number')->orderBy('sort_order');
    }
}
