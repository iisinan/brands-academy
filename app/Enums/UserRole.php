<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Member = 'member';

    /**
     * Get human-readable role label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Member => 'Foundation Member',
        };
    }

    /**
     * Get default dashboard route for this role.
     */
    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Admin => 'admin.dashboard',
            self::Member => 'member.dashboard',
        };
    }

    /**
     * Get badge styling classes for UI display.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Admin => 'bg-slate-900 text-amber-400 border border-amber-500/30',
            self::Member => 'bg-amber-100 text-amber-900 border border-amber-300',
        };
    }

    /**
     * Get descriptive summary of access privileges for this role.
     */
    public function description(): string
    {
        return match ($this) {
            self::Admin => 'Full institutional governance: User & RBAC provisioning, workshop cohorts, admissions, grading, certificate issuance, and partnerships.',
            self::Member => 'Member services: Dedicated portal, digital ID card, cohort applications, portfolio submissions, and digital credential verification.',
        };
    }

    /**
     * Get permission keys assigned to this role.
     *
     * @return array<int, string>
     */
    public function permissions(): array
    {
        return match ($this) {
            self::Admin => [
                'view_admin_panel',
                'manage_users',
                'manage_workshops',
                'manage_admissions',
                'evaluate_portfolios',
                'manage_credentials',
                'manage_inquiries',
                'view_member_portal',
            ],
            self::Member => [
                'view_member_portal',
                'apply_workshops',
                'submit_portfolio',
                'view_credentials',
            ],
        };
    }

    /**
     * Check if this role possesses a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions(), true);
    }
}
