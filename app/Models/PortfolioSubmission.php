<?php

namespace App\Models;

use Database\Factories\PortfolioSubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioSubmission extends Model
{
    /** @use HasFactory<PortfolioSubmissionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'workshop_application_id',
        'workshop_id',
        'member_id',
        'title',
        'description',
        'deck_url',
        'deliverables',
        'status',
        'grade',
        'mentor_feedback',
        'reviewed_by',
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
            'deliverables' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * Associated workshop application.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(WorkshopApplication::class, 'workshop_application_id');
    }

    /**
     * Associated workshop.
     */
    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    /**
     * Associated member profile.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Status badge styling.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'approved' => ['label' => 'Approved / Passed', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
            'under_review' => ['label' => 'Under Mentor Review', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
            'revisions_requested' => ['label' => 'Revisions Needed', 'class' => 'bg-rose-100 text-rose-800 border-rose-200'],
            default => ['label' => 'Submitted', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
        };
    }
}
