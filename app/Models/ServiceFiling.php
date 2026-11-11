<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ServiceFiling extends Model
{
    use HasFactory;

    public const TYPE_CAC_BUSINESS_NAME = 'cac_business_name';

    public const TYPE_CAC_COMPANY_LTD = 'cac_company_ltd';

    public const TYPE_TRADEMARK = 'trademark';

    public const TYPE_PATENT = 'patent';

    public const TYPE_COPYRIGHT = 'copyright';

    public const STATUS_PAYMENT_PENDING = 'payment_pending';

    public const STATUS_SUBMITTED = 'submitted';

    public const STATUS_SEARCH_IN_PROGRESS = 'search_in_progress';

    public const STATUS_LODGED_AT_REGISTRY = 'lodged_at_registry';

    public const STATUS_QUERIED = 'queried';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'tracking_code',
        'user_id',
        'member_id',
        'filing_type',
        'proposed_name_1',
        'proposed_name_2',
        'proposed_name_3',
        'business_nature',
        'industry_category',
        'business_address',
        'headquarters_state',
        'client_first_name',
        'client_last_name',
        'client_email',
        'client_phone',
        'client_nin',
        'filing_data',
        'status',
        'total_fee',
        'member_discount',
        'fee_paid',
        'payment_gateway',
        'payment_reference',
        'government_filing_number',
        'official_certificate_path',
        'admin_notes',
        'client_query_message',
        'submitted_at',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'filing_data' => 'array',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'total_fee' => 'decimal:2',
            'member_discount' => 'decimal:2',
            'fee_paid' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ServiceFiling $filing): void {
            if (empty($filing->tracking_code)) {
                $prefix = match ($filing->filing_type) {
                    self::TYPE_CAC_COMPANY_LTD => 'BANF-LTD',
                    self::TYPE_TRADEMARK => 'BANF-TM',
                    self::TYPE_PATENT => 'BANF-PAT',
                    self::TYPE_COPYRIGHT => 'BANF-CPR',
                    default => 'BANF-CAC',
                };
                $filing->tracking_code = $prefix.'-'.date('Y').'-'.strtoupper(Str::random(6));
            }
        });
    }

    public static function getPricing(string $type): array
    {
        $rates = [
            self::TYPE_CAC_BUSINESS_NAME => [
                'type' => self::TYPE_CAC_BUSINESS_NAME,
                'title' => 'CAC Business Name (Sole Prop / Enterprise)',
                'badge' => 'Fastest Setup',
                'regular' => 35000.00,
                'member' => 26250.00,
                'timeline' => '3–5 Working Days',
                'description' => 'Official registration of your venture with the Corporate Affairs Commission, including Certified Certificate & Status Report.',
            ],
            self::TYPE_CAC_COMPANY_LTD => [
                'type' => self::TYPE_CAC_COMPANY_LTD,
                'title' => 'CAC Private Limited Company (LTD)',
                'badge' => 'Full Corporate Protection',
                'regular' => 75000.00,
                'member' => 56250.00,
                'timeline' => '5–7 Working Days',
                'description' => 'Incorporation of Private Limited Liability Company, CAC RC Certificate, MEMART, Tax ID (TIN), and full corporate status report.',
            ],
            self::TYPE_TRADEMARK => [
                'type' => self::TYPE_TRADEMARK,
                'title' => 'Trademark Protection (Logo & Wordmark)',
                'badge' => 'Brand IP Shield',
                'regular' => 85000.00,
                'member' => 63750.00,
                'timeline' => 'Filing & Ack in 48h, Acceptance in 3–4 Weeks',
                'description' => 'Statutory brand name and device mark protection at the Federal Ministry of Industry, Trade and Investment (Commercial Law Dept).',
            ],
            self::TYPE_PATENT => [
                'type' => self::TYPE_PATENT,
                'title' => 'Patent & Industrial Design Filing',
                'badge' => 'Technology & Design IP',
                'regular' => 120000.00,
                'member' => 90000.00,
                'timeline' => 'Statutory Priority Search & Lodgement',
                'description' => 'Protection for technical inventions, novel packaging forms, industrial product designs, and functional innovations.',
            ],
            self::TYPE_COPYRIGHT => [
                'type' => self::TYPE_COPYRIGHT,
                'title' => 'Copyright Deposit & Asset Protection',
                'badge' => 'Creative Works & Manuals',
                'regular' => 45000.00,
                'member' => 33750.00,
                'timeline' => '5–10 Working Days',
                'description' => 'Nigerian Copyright Commission (NCC) certified deposit of brand books, identity manuals, software codes, and creative assets.',
            ],
        ];

        return $rates[$type] ?? $rates[self::TYPE_CAC_BUSINESS_NAME];
    }

    public static function allPricing(): array
    {
        return [
            self::TYPE_CAC_BUSINESS_NAME => self::getPricing(self::TYPE_CAC_BUSINESS_NAME),
            self::TYPE_CAC_COMPANY_LTD => self::getPricing(self::TYPE_CAC_COMPANY_LTD),
            self::TYPE_TRADEMARK => self::getPricing(self::TYPE_TRADEMARK),
            self::TYPE_PATENT => self::getPricing(self::TYPE_PATENT),
            self::TYPE_COPYRIGHT => self::getPricing(self::TYPE_COPYRIGHT),
        ];
    }

    public function getTypeTitleAttribute(): string
    {
        return self::getPricing($this->filing_type)['title'] ?? 'Legal Registration';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PAYMENT_PENDING => 'Payment Pending',
            self::STATUS_SUBMITTED => 'Lodged & Submitted',
            self::STATUS_SEARCH_IN_PROGRESS => 'Name Search In Progress',
            self::STATUS_LODGED_AT_REGISTRY => 'Lodged at Registry',
            self::STATUS_QUERIED => 'Action Required (Queried)',
            self::STATUS_APPROVED => 'Approved & Certified',
            self::STATUS_DELIVERED => 'Delivered to Client',
            self::STATUS_REJECTED => 'Rejected by Registry',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusStepIndexAttribute(): int
    {
        return match ($this->status) {
            self::STATUS_PAYMENT_PENDING => 0,
            self::STATUS_SUBMITTED => 1,
            self::STATUS_SEARCH_IN_PROGRESS => 2,
            self::STATUS_LODGED_AT_REGISTRY => 3,
            self::STATUS_QUERIED => 3,
            self::STATUS_APPROVED, self::STATUS_DELIVERED => 4,
            default => 1,
        };
    }

    public function isQueried(): bool
    {
        return $this->status === self::STATUS_QUERIED;
    }

    public function isApproved(): bool
    {
        return in_array($this->status, [self::STATUS_APPROVED, self::STATUS_DELIVERED], true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(FilingDocument::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(FilingStatusLog::class)->orderBy('id', 'desc');
    }
}
