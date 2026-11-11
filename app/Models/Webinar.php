<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Webinar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'speaker_name',
        'speaker_title',
        'speaker_bio',
        'speaker_avatar',
        'summary',
        'description',
        'starts_at',
        'duration_minutes',
        'fee_type',
        'regular_price',
        'member_price',
        'meeting_provider',
        'meeting_link',
        'access_passcode',
        'recording_url',
        'status',
        'max_attendees',
        'banner_path',
        'is_published',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'duration_minutes' => 'integer',
            'regular_price' => 'decimal:2',
            'member_price' => 'decimal:2',
            'max_attendees' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Booted method to handle slug generation.
     */
    protected static function booted(): void
    {
        static::creating(function (Webinar $webinar): void {
            if (empty($webinar->slug)) {
                $webinar->slug = Str::slug($webinar->title).'-'.Str::random(5);
            }
            if ($webinar->fee_type === 'free') {
                $webinar->regular_price = 0;
                $webinar->member_price = 0;
            } elseif ($webinar->member_price <= 0 && $webinar->regular_price > 0) {
                $webinar->member_price = round($webinar->regular_price * 0.75, 2);
            }
        });
    }

    /**
     * Registrations for this webinar.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(WebinarRegistration::class);
    }

    /**
     * Calculate effective fee for a user (25% off if member).
     */
    public function calculateFeeFor(?User $user): float
    {
        if ($this->fee_type === 'free' || $this->regular_price <= 0) {
            return 0.0;
        }

        if ($user && ($user->isMember() || $user->isAdmin())) {
            return (float) ($this->member_price > 0 ? $this->member_price : round($this->regular_price * 0.75, 2));
        }

        return (float) $this->regular_price;
    }

    /**
     * Check if upcoming or live.
     */
    public function isUpcoming(): bool
    {
        return $this->starts_at->isFuture();
    }

    public function isLive(): bool
    {
        $now = Carbon::now();
        $endsAt = $this->starts_at->copy()->addMinutes($this->duration_minutes);

        return $now->between($this->starts_at, $endsAt);
    }

    public function formattedPrice(): string
    {
        return $this->fee_type === 'free' || $this->regular_price <= 0
            ? 'Free'
            : '₦'.number_format($this->regular_price, 2);
    }

    /**
     * Audience Q&A questions submitted in advance or during session.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(WebinarQuestion::class)->orderByDesc('upvotes_count')->latest();
    }
}
