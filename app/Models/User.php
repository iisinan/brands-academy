<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Check if user has an administrator role.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::Admin);
    }

    /**
     * Check if user has a member role.
     */
    public function isMember(): bool
    {
        return $this->hasRole(UserRole::Member);
    }

    /**
     * Check if user has one of the specified roles.
     *
     * @param  UserRole|string|array<UserRole|string>  $roles
     */
    public function hasRole(UserRole|string|array $roles): bool
    {
        $currentValue = $this->role instanceof UserRole ? $this->role->value : (string) $this->role;
        $roleList = is_array($roles) ? $roles : [$roles];

        foreach ($roleList as $role) {
            $value = $role instanceof UserRole ? $role->value : (string) $role;
            if ($currentValue === $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the default dashboard route for this user.
     */
    public function getDashboardRoute(): string
    {
        if ($this->role instanceof UserRole) {
            return $this->role->dashboardRoute();
        }

        return $this->isAdmin() ? 'admin.dashboard' : 'member.dashboard';
    }

    /**
     * Accessor for human-readable role name.
     */
    public function getRoleLabelAttribute(): string
    {
        if ($this->role instanceof UserRole) {
            return $this->role->label();
        }

        return $this->isAdmin() ? 'Administrator' : 'Foundation Member';
    }

    /**
     * Accessor for role badge CSS classes.
     */
    public function getRoleBadgeClassesAttribute(): string
    {
        if ($this->role instanceof UserRole) {
            return $this->role->badgeClasses();
        }

        return $this->isAdmin()
            ? 'bg-slate-900 text-amber-400 border border-amber-500/30'
            : 'bg-amber-100 text-amber-900 border border-amber-300';
    }

    /**
     * Check if user possesses a specific permission.
     */
    public function canPerform(string $permission): bool
    {
        if ($this->role instanceof UserRole) {
            return $this->role->hasPermission($permission);
        }

        return $this->isAdmin();
    }

    /**
     * Alias for canPerform.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->canPerform($permission);
    }

    /**
     * Associated member profile.
     */
    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    /**
     * Workshop applications submitted by the user.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(WorkshopApplication::class);
    }
}
