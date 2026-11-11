<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'volume_id',
        'issue_number',
        'title',
        'published_date',
        'cover_image_path',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'issue_number' => 'integer',
            'published_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function volume(): BelongsTo
    {
        return $this->belongsTo(JournalVolume::class, 'volume_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(JournalArticle::class, 'issue_id');
    }

    public function publishedArticles(): HasMany
    {
        return $this->hasMany(JournalArticle::class, 'issue_id')
            ->where('submission_status', JournalArticle::STATUS_PUBLISHED)
            ->orderBy('page_start', 'asc');
    }

    public function getIssueCitationAttribute(): string
    {
        $vol = $this->volume ? "Vol. {$this->volume->volume_number}" : '';

        return "{$vol}, No. {$this->issue_number} ({$this->published_date->format('Y')})";
    }
}
