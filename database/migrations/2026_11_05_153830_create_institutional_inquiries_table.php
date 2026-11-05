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
        Schema::create('institutional_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone');
            $table->string('organization_type')->default('corporate'); // corporate, higher_education, government, ngo, other
            $table->string('solution_interest')->default('staff_training'); // staff_training, curriculum_licensing, strategic_advisory, community_sponsorship
            $table->unsignedInteger('estimated_cohort_size')->nullable();
            $table->string('target_timeline')->nullable();
            $table->text('message');
            $table->string('status')->default('new'); // new, contacted, in_discussion, partnered, closed
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutional_inquiries');
    }
};
