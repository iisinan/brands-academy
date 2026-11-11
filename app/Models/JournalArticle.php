<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JournalArticle extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_SUBMITTED = 'submitted';

    public const STATUS_UNDER_REVIEW = 'under_review';

    public const STATUS_REVISION_REQUIRED = 'revision_required';

    public const STATUS_ACCEPTED = 'accepted';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_DECLINED = 'declined';

    protected $fillable = [
        'issue_id',
        'submitted_by_user_id',
        'title',
        'slug',
        'abstract',
        'keywords',
        'doi',
        'manuscript_pdf_path',
        'page_start',
        'page_end',
        'submission_status',
        'views_count',
        'downloads_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'page_start' => 'integer',
            'page_end' => 'integer',
            'views_count' => 'integer',
            'downloads_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (JournalArticle $article): void {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title).'-'.strtolower(Str::random(5));
            }
        });
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(JournalIssue::class, 'issue_id');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    public function authors(): HasMany
    {
        return $this->hasMany(ArticleAuthor::class, 'article_id')->orderBy('sort_order', 'asc');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ManuscriptReview::class, 'article_id');
    }

    public function getAuthorsFormattedAttribute(): string
    {
        return $this->authors->pluck('full_name')->join(', ', ' & ');
    }

    public function getKeywordsArrayAttribute(): array
    {
        if (empty($this->keywords)) {
            return [];
        }

        return array_map('trim', explode(',', $this->keywords));
    }

    public function generateApaCitation(): string
    {
        $authors = $this->authors_formatted ?: 'Brands Academy Faculty';
        $year = $this->published_at ? $this->published_at->format('Y') : date('Y');
        $vol = $this->issue?->volume ? $this->issue->volume->volume_number : '1';
        $iss = $this->issue ? $this->issue->issue_number : '1';
        $pages = ($this->page_start && $this->page_end) ? ", {$this->page_start}-{$this->page_end}" : '';
        $doi = $this->doi ? " https://doi.org/{$this->doi}" : '';

        return "{$authors} ({$year}). {$this->title}. Journal of Brand Strategy & Management, {$vol}({$iss}){$pages}.{$doi}";
    }

    public function generateHarvardCitation(): string
    {
        $authors = $this->authors_formatted ?: 'Brands Academy Faculty';
        $year = $this->published_at ? $this->published_at->format('Y') : date('Y');
        $vol = $this->issue?->volume ? $this->issue->volume->volume_number : '1';
        $iss = $this->issue ? $this->issue->issue_number : '1';
        $pages = ($this->page_start && $this->page_end) ? ", pp.{$this->page_start}-{$this->page_end}" : '';

        return "{$authors}, {$year}. {$this->title}. Journal of Brand Strategy & Management, {$vol}({$iss}){$pages}.";
    }

    public function generateBibtexCitation(): string
    {
        $firstAuthor = $this->authors->first()?->full_name ?: 'Author';
        $key = strtolower(Str::slug($firstAuthor)).($this->published_at ? $this->published_at->format('Y') : '2026');
        $authors = $this->authors->pluck('full_name')->join(' and ');
        $year = $this->published_at ? $this->published_at->format('Y') : '2026';
        $vol = $this->issue?->volume ? $this->issue->volume->volume_number : '1';
        $iss = $this->issue ? $this->issue->issue_number : '1';

        return "@article{{$key},\n"
            ."  title = {{$this->title}},\n"
            ."  author = {{$authors}},\n"
            ."  journal = {Journal of Brand Strategy & Management},\n"
            ."  volume = {{$vol}},\n"
            ."  number = {{$iss}},\n"
            ."  year = {{$year}}\n"
            .'}';
    }
}
