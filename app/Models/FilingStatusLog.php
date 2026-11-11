<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilingStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_filing_id',
        'from_status',
        'to_status',
        'changed_by_user_id',
        'remarks',
    ];

    public function serviceFiling(): BelongsTo
    {
        return $this->belongsTo(ServiceFiling::class);
    }

    public function changedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }
}
