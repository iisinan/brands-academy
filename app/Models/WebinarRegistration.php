<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class WebinarRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'webinar_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'organization',
        'amount_paid',
        'payment_gateway',
        'payment_reference',
        'attended',
        'token',
        'reminder_sent_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'attended' => 'boolean',
            'reminder_sent_at' => 'datetime',
        ];
    }

    /**
     * Booted method to handle token generation.
     */
    protected static function booted(): void
    {
        static::creating(function (WebinarRegistration $registration): void {
            if (empty($registration->token)) {
                $registration->token = 'WBN-'.strtoupper(Str::random(12));
            }
        });
    }

    /**
     * Parent webinar.
     */
    public function webinar(): BelongsTo
    {
        return $this->belongsTo(Webinar::class);
    }

    /**
     * Registered user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Full registrant name.
     */
    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
