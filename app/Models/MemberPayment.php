<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MemberPayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'member_id',
        'user_id',
        'reference',
        'category',
        'amount',
        'currency',
        'payment_gateway',
        'status',
        'gateway_reference',
        'receipt_path',
        'notes',
        'paid_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Generate unique payment reference on creating.
     */
    protected static function booted(): void
    {
        static::creating(function (MemberPayment $payment): void {
            if (empty($payment->reference)) {
                $payment->reference = 'BANF-PAY-'.date('Y').'-'.strtoupper(Str::random(7));
            }
            if (empty($payment->currency)) {
                $payment->currency = 'NGN';
            }
        });
    }

    /**
     * Member associated with this payment.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * User account associated with this payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if payment succeeded.
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'successful';
    }

    /**
     * Check if payment is awaiting admin confirmation.
     */
    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    /**
     * Formatted amount with currency symbol.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₦'.number_format((float) $this->amount);
    }
}
