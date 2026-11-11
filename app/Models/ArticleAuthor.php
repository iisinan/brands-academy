<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'full_name',
        'affiliation',
        'email',
        'orcid_id',
        'is_corresponding',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_corresponding' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(JournalArticle::class, 'article_id');
    }
}
