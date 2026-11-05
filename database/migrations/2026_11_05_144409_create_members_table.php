<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('member_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('category')->default('professional'); // student, professional, corporate, fellow
            $table->string('institution_or_company')->nullable();
            $table->string('designation')->nullable();
            $table->string('state')->default('Kaduna');
            $table->string('country')->default('Nigeria');
            $table->string('status')->default('active'); // active, pending, suspended
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('qr_code_token')->unique();
            $table->date('joined_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
