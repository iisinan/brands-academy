<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManuscriptReview extends Model
{
    use HasFactory;

    public const REC_ACCEPT = 'accept';

    public const REC_MINOR_REVISIONS = 'minor_revisions';

    public const REC_MAJOR_REVISIONS = 'major_revisions';

    public const REC_REJECT = 'reject';

    protected $fillable = [
        'article_id',
        'reviewer_user_id',
        'recommendation',
        'comments_for_authors',
        'confidential_editorial_notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(JournalArticle::class, 'article_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }
}
