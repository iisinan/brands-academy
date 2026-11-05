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
        Schema::create('portfolio_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('deck_url');
            $table->json('deliverables')->nullable();
            $table->string('status')->default('submitted'); // submitted, under_review, approved, revisions_requested
            $table->string('grade')->nullable(); // pass, merit, distinction
            $table->text('mentor_feedback')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_submissions');
    }
};
