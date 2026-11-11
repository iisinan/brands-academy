<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class JournalVolume extends Model
{
    use HasFactory;

    protected $fillable = [
        'volume_number',
        'year',
        'title',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'volume_number' => 'integer',
            'year' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function issues(): HasMany
    {
        return $this->hasMany(JournalIssue::class, 'volume_id')->orderBy('issue_number', 'asc');
    }

    public function articles(): HasManyThrough
    {
        return $this->hasManyThrough(JournalArticle::class, JournalIssue::class, 'volume_id', 'issue_id');
    }
}
