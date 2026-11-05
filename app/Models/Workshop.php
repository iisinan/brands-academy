<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\WorkshopFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Workshop extends Model
{
    /** @use HasFactory<WorkshopFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'track_type',
        'tagline',
        'description',
        'curriculum_topics',
        'delivery_mode',
        'venue',
        'fee_type',
        'fee_amount',
        'capacity',
        'application_starts_at',
        'application_deadline',
        'starts_at',
        'ends_at',
        'instructor_name',
        'status',
        'is_featured',
        'banner_image',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'curriculum_topics' => 'array',
            'fee_amount' => 'decimal:2',
            'application_starts_at' => 'datetime',
            'application_deadline' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Booted method to handle slug generation.
     */
    protected static function booted(): void
    {
        static::creating(function (Workshop $workshop): void {
            if (empty($workshop->slug)) {
                $workshop->slug = Str::slug($workshop->title).'-'.Str::random(5);
            }
        });
    }

    /**
     * Applications submitted for this workshop.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(WorkshopApplication::class);
    }

    /**
     * Certificates issued for this workshop.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Check if application window is currently active.
     */
    public function isOpenForApplications(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        $now = Carbon::now();

        return $now->between($this->application_starts_at, $this->application_deadline);
    }

    /**
     * Check if the application window has not yet opened.
     */
    public function isUpcoming(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        return Carbon::now()->lt($this->application_starts_at);
    }

    /**
     * Check if the application deadline has elapsed.
     */
    public function isApplicationClosed(): bool
    {
        return Carbon::now()->gt($this->application_deadline);
    }

    /**
     * Get remaining days/hours for application deadline.
     */
    public function getApplicationWindowStatusAttribute(): array
    {
        $now = Carbon::now();

        if ($this->isOpenForApplications()) {
            $diff = $now->diffForHumans($this->application_deadline, [
                'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
                'parts' => 2,
            ]);

            return [
                'state' => 'open',
                'label' => 'Applications Open',
                'detail' => 'Closes '.$diff,
                'badge_class' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            ];
        }

        if ($this->isUpcoming()) {
            $diff = $now->diffForHumans($this->application_starts_at, [
                'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
                'parts' => 2,
            ]);

            return [
                'state' => 'upcoming',
                'label' => 'Opening Soon',
                'detail' => 'Opens '.$diff,
                'badge_class' => 'bg-amber-100 text-amber-800 border-amber-300',
            ];
        }

        return [
            'state' => 'closed',
            'label' => 'Applications Closed',
            'detail' => 'Review in progress',
            'badge_class' => 'bg-slate-100 text-slate-700 border-slate-300',
        ];
    }

    /**
     * Human-readable track label.
     */
    public function getTrackLabelAttribute(): string
    {
        return match ($this->track_type) {
            'cba' => 'Tier 1: Certified Brand Associate (CBA)',
            'cbs' => 'Tier 2: Certified Brand Strategist (CBS)',
            'cbe' => 'Tier 3: Certified Brand Executive (CBE)',
            'community' => 'Community & Vocational Track (Free-Access)',
            'executive' => 'Executive Masterclass / Retreat',
            'workshop' => 'Specialized Brand Workshop',
            default => ucfirst($this->track_type),
        };
    }
}
