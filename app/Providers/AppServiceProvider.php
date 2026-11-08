<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        Gate::define('admin', fn (User $user): bool => $user->isAdmin());
        Gate::define('member', fn (User $user): bool => $user->isMember());

        // RBAC Granular Capability Gates
        foreach ([
            'view-admin-panel' => 'view_admin_panel',
            'manage-users' => 'manage_users',
            'manage-workshops' => 'manage_workshops',
            'manage-admissions' => 'manage_admissions',
            'evaluate-portfolios' => 'evaluate_portfolios',
            'manage-credentials' => 'manage_credentials',
            'manage-inquiries' => 'manage_inquiries',
            'view-member-portal' => 'view_member_portal',
            'apply-workshops' => 'apply_workshops',
            'submit-portfolio' => 'submit_portfolio',
        ] as $gate => $permission) {
            Gate::define($gate, fn (User $user): bool => $user->canPerform($permission));
        }
    }
}
