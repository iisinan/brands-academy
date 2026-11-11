<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConferenceTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id',
        'name',
        'regular_price',
        'member_price',
        'quantity_available',
        'quantity_sold',
        'benefits',
    ];

    protected function casts(): array
    {
        return [
            'regular_price' => 'decimal:2',
            'member_price' => 'decimal:2',
            'quantity_available' => 'integer',
            'quantity_sold' => 'integer',
            'benefits' => 'array',
        ];
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function delegates(): HasMany
    {
        return $this->hasMany(ConferenceDelegate::class, 'ticket_id');
    }

    public function isSoldOut(): bool
    {
        return $this->quantity_sold >= $this->quantity_available;
    }

    public function calculatePriceFor(?User $user = null): float
    {
        if ($user && $user->member && $user->member->isPaid()) {
            return (float) $this->member_price;
        }

        return (float) $this->regular_price;
    }
}
