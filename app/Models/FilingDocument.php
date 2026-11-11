<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilingDocument extends Model
{
    use HasFactory;

    public const TYPE_NIN_SLIP = 'nin_slip';

    public const TYPE_PASSPORT_PHOTO = 'passport_photo';

    public const TYPE_SIGNATURE_SPECIMEN = 'signature_specimen';

    public const TYPE_TRADEMARK_LOGO = 'trademark_logo';

    public const TYPE_CAC_CONSENT = 'cac_consent';

    public const TYPE_PATENT_SPECIFICATION = 'patent_specification';

    public const TYPE_OTHER = 'other';

    protected $fillable = [
        'service_filing_id',
        'document_type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'is_verified',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'is_verified' => 'boolean',
        ];
    }

    public function serviceFiling(): BelongsTo
    {
        return $this->belongsTo(ServiceFiling::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->document_type) {
            self::TYPE_NIN_SLIP => 'National ID / NIN Slip',
            self::TYPE_PASSPORT_PHOTO => 'Passport Photograph',
            self::TYPE_SIGNATURE_SPECIMEN => 'Signature Specimen',
            self::TYPE_TRADEMARK_LOGO => 'Brand Logo / Device Representation',
            self::TYPE_CAC_CONSENT => 'Consent Letter / Resolution',
            self::TYPE_PATENT_SPECIFICATION => 'Patent Specification & Drawings',
            default => ucfirst(str_replace('_', ' ', $this->document_type)),
        };
    }

    public function getFormattedSizeAttribute(): string
    {
        if (! $this->file_size) {
            return 'Document';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $this->file_size > 0 ? floor(log($this->file_size, 1024)) : 0;

        return number_format($this->file_size / (1024 ** $power), 1).' '.$units[$power];
    }
}
