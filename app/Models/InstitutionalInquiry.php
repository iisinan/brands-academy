<?php

namespace App\Models;

use Database\Factories\InstitutionalInquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionalInquiry extends Model
{
    /** @use HasFactory<InstitutionalInquiryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_name',
        'contact_person',
        'email',
        'phone',
        'organization_type',
        'solution_interest',
        'estimated_cohort_size',
        'target_timeline',
        'message',
        'status',
        'admin_notes',
    ];

    /**
     * Human readable organization type.
     */
    public function getOrganizationTypeLabelAttribute(): string
    {
        return match ($this->organization_type) {
            'higher_education' => 'University / Tertiary College',
            'government' => 'Government / Public Sector',
            'ngo' => 'Development Agency / NGO',
            'corporate' => 'Corporate Organization / Agency',
            default => ucfirst($this->organization_type),
        };
    }

    /**
     * Human readable solution label.
     */
    public function getSolutionInterestLabelAttribute(): string
    {
        return match ($this->solution_interest) {
            'staff_training' => 'Corporate Staff Capacity Building',
            'curriculum_licensing' => 'Curriculum Licensing & Co-Branding',
            'strategic_advisory' => 'Brand Strategy & Communications Advisory',
            'community_sponsorship' => 'Community Training & CSR Sponsorship',
            default => ucfirst($this->solution_interest),
        };
    }

    /**
     * Status badge styling.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'partnered' => ['label' => 'Partnership Active', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
            'in_discussion' => ['label' => 'In Discussion', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
            'contacted' => ['label' => 'Contacted', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
            'closed' => ['label' => 'Closed', 'class' => 'bg-slate-100 text-slate-800 border-slate-200'],
            default => ['label' => 'New Inquiry', 'class' => 'bg-rose-100 text-rose-800 border-rose-200'],
        };
    }
}
