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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('theme')->nullable();
            $table->unsignedSmallInteger('year')->default(2026);
            $table->string('venue')->nullable(); // Physical address or 'Virtual / Hybrid'
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->text('description')->nullable();
            $table->json('keynote_speakers')->nullable();
            $table->json('schedule_agenda')->nullable();
            $table->string('banner_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('cfp_open')->default(true); // Call For Papers open
            $table->date('cfp_deadline')->nullable();
            $table->timestamps();
        });

        Schema::create('conference_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Student, Regular, Member, VIP/Corporate
            $table->decimal('regular_price', 12, 2)->default(0.00);
            $table->decimal('member_price', 12, 2)->default(0.00);
            $table->unsignedInteger('quantity_available')->default(100);
            $table->unsignedInteger('quantity_sold')->default(0);
            $table->json('benefits')->nullable();
            $table->timestamps();
        });

        Schema::create('conference_delegates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_id')->constrained('conference_tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->string('badge_code')->unique();
            $table->decimal('amount_paid', 12, 2)->default(0.00);
            $table->string('payment_reference')->nullable();
            $table->boolean('checked_in')->default(false);
            $table->dateTime('checked_in_at')->nullable();
            $table->timestamps();
        });

        Schema::create('call_for_papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_institution');
            $table->text('abstract_text');
            $table->string('keywords')->nullable();
            $table->string('manuscript_pdf_path')->nullable();
            $table->string('review_status')->default('submitted'); // submitted, under_review, accepted_presentation, accepted_poster, rejected
            $table->text('reviewer_feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_for_papers');
        Schema::dropIfExists('conference_delegates');
        Schema::dropIfExists('conference_tickets');
        Schema::dropIfExists('conferences');
    }
};
