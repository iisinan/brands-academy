<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ConferenceDelegate extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id',
        'ticket_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'organization',
        'designation',
        'badge_code',
        'amount_paid',
        'payment_reference',
        'checked_in',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'checked_in' => 'boolean',
            'checked_in_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ConferenceDelegate $delegate): void {
            if (empty($delegate->badge_code)) {
                $delegate->badge_code = 'BANF-CONF-'.date('Y').'-'.strtoupper(Str::random(6));
            }
        });
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(ConferenceTicket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
