<?php

namespace App\Models;

use Database\Factories\WorkshopApplicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkshopApplication extends Model
{
    /** @use HasFactory<WorkshopApplicationFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'workshop_id',
        'member_id',
        'user_id',
        'applicant_name',
        'applicant_email',
        'applicant_phone',
        'applicant_organization',
        'statement_of_purpose',
        'portfolio_link',
        'scholarship_requested',
        'scholarship_reason',
        'status',
        'admin_notes',
        'reviewed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scholarship_requested' => 'boolean',
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * Associated workshop/cohort.
     */
    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    /**
     * Associated member profile if applied as a registered member.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Associated user account if logged in.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generated certificate upon graduation.
     */
    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    /**
     * Practical portfolio submissions for evaluation.
     */
    public function portfolioSubmissions(): HasMany
    {
        return $this->hasMany(PortfolioSubmission::class);
    }

    /**
     * Status badge styling.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'accepted' => ['label' => 'Accepted', 'class' => 'bg-emerald-100 text-emerald-800'],
            'waitlisted' => ['label' => 'Waitlisted', 'class' => 'bg-amber-100 text-amber-800'],
            'rejected' => ['label' => 'Not Selected', 'class' => 'bg-rose-100 text-rose-800'],
            'completed' => ['label' => 'Graduated', 'class' => 'bg-blue-100 text-blue-800'],
            default => ['label' => 'Pending Review', 'class' => 'bg-slate-100 text-slate-800'],
        };
    }
}
