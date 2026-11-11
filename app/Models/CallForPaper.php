<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallForPaper extends Model
{
    use HasFactory;

    protected $table = 'call_for_papers';

    public const STATUS_SUBMITTED = 'submitted';

    public const STATUS_UNDER_REVIEW = 'under_review';

    public const STATUS_ACCEPTED_PRESENTATION = 'accepted_presentation';

    public const STATUS_ACCEPTED_POSTER = 'accepted_poster';

    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'conference_id',
        'user_id',
        'title',
        'author_name',
        'author_email',
        'author_institution',
        'abstract_text',
        'keywords',
        'manuscript_pdf_path',
        'review_status',
        'reviewer_feedback',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->review_status) {
            self::STATUS_SUBMITTED => 'Submitted & Screening',
            self::STATUS_UNDER_REVIEW => 'Under Peer Review',
            self::STATUS_ACCEPTED_PRESENTATION => 'Accepted for Oral Presentation',
            self::STATUS_ACCEPTED_POSTER => 'Accepted for Poster Session',
            self::STATUS_REJECTED => 'Declined / Revisions Suggested',
            default => ucfirst(str_replace('_', ' ', $this->review_status)),
        };
    }
}
