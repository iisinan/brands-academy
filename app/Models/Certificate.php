<?php

namespace App\Models;

use Database\Factories\CertificateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Certificate extends Model
{
    /** @use HasFactory<CertificateFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'certificate_number',
        'verification_token',
        'workshop_id',
        'course_id',
        'workshop_application_id',
        'member_id',
        'recipient_name',
        'recipient_email',
        'course_title',
        'track_tier',
        'issued_at',
        'pdf_path',
        'email_sent_at',
        'email_status',
        'email_error',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'email_sent_at' => 'datetime',
        ];
    }

    /**
     * Booted method to handle token and number generation.
     */
    protected static function booted(): void
    {
        static::creating(function (Certificate $certificate): void {
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = 'BANF-CERT-'.date('Y').'-'.strtoupper(Str::random(6));
            }
            if (empty($certificate->verification_token)) {
                $certificate->verification_token = (string) Str::uuid();
            }
            if (empty($certificate->issued_at)) {
                $certificate->issued_at = now()->toDateString();
            }
        });
    }

    /**
     * Associated workshop.
     */
    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    /**
     * Associated LMS course.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Associated application.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(WorkshopApplication::class, 'workshop_application_id');
    }

    /**
     * Associated member profile.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * URL for public verification of this certificate.
     */
    public function getVerificationUrlAttribute(): string
    {
        return route('verify.certificate', $this->verification_token);
    }
}
