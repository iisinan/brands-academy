<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $admin = User::firstOrNew(['email' => 'admin@brandsacademy.org']);
        $admin->name = 'Brands Academy Admin';
        $admin->password = Hash::make('password');
        $admin->role = UserRole::Admin;
        $admin->email_verified_at = now();
        $admin->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
