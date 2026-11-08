<?php

namespace App\Models;

use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Member extends Model
{
    /** @use HasFactory<MemberFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'member_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'category',
        'institution_or_company',
        'designation',
        'state',
        'country',
        'status',
        'payment_status',
        'payment_method',
        'paid_amount',
        'paid_at',
        'payment_reference',
        'payment_proof',
        'bio',
        'avatar',
        'qr_code_token',
        'joined_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'joined_at' => 'date',
            'paid_at' => 'datetime',
            'paid_amount' => 'decimal:2',
        ];
    }

    /**
     * Automatically populate member_number and qr_code_token on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (Member $member): void {
            if (empty($member->member_number)) {
                $member->member_number = 'BANF-MBR-'.date('Y').'-'.strtoupper(Str::random(5));
            }
            if (empty($member->qr_code_token)) {
                $member->qr_code_token = (string) Str::uuid();
            }
            if (empty($member->joined_at)) {
                $member->joined_at = now()->toDateString();
            }
        });
    }

    /**
     * Full Name accessor.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => "{$this->first_name} {$this->last_name}",
        );
    }

    /**
     * User account relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Applications submitted by this member.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(WorkshopApplication::class);
    }

    /**
     * Certificates awarded to this member.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Payments recorded for this member.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(MemberPayment::class);
    }

    /**
     * Check if membership dues are paid and active.
     */
    public function isPaid(): bool
    {
        return in_array($this->payment_status, ['paid', 'waived']);
    }

    /**
     * Check if payment is awaiting transfer proof or admin verification.
     */
    public function isUnderReview(): bool
    {
        return $this->payment_status === 'under_review';
    }

    /**
     * Check if payment has not yet been initiated.
     */
    public function isPendingPayment(): bool
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Get the configured fee amount for this member's category.
     */
    public function getFeeAmount(): float
    {
        return (float) config("membership.fees.{$this->category}.amount", 25000);
    }

    /**
     * Get formatted fee string with currency symbol.
     */
    public function getFeeFormatted(): string
    {
        return '₦'.number_format($this->getFeeAmount());
    }

    /**
     * Mark membership as successfully paid and active.
     */
    public function markAsPaid(string $method = 'paystack', ?float $amount = null, ?string $reference = null): void
    {
        $this->update([
            'payment_status' => 'paid',
            'status' => 'active',
            'payment_method' => $method,
            'paid_amount' => $amount ?? $this->getFeeAmount(),
            'paid_at' => now(),
            'payment_reference' => $reference ?? $this->payment_reference,
        ]);
    }

    /**
     * Human-readable category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'student' => 'Student Member',
            'professional' => 'Professional Member',
            'corporate' => 'Corporate Member',
            'fellow' => 'Fellow / Academic Member',
            default => ucfirst($this->category),
        };
    }
}
