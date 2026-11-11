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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->string('track')->default('Brand Strategy');
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();
            $table->string('instructor_name')->nullable();
            $table->string('instructor_title')->nullable();
            $table->text('instructor_bio')->nullable();
            $table->string('instructor_avatar')->nullable();
            $table->string('delivery_mode')->default('self_paced'); // self_paced, live_cohort, hybrid
            $table->string('fee_type')->default('paid'); // free, paid
            $table->decimal('regular_price', 10, 2)->default(0);
            $table->decimal('member_price', 10, 2)->default(0);
            $table->string('meeting_provider')->default('google_meet'); // google_meet, zoom, youtube_live
            $table->string('meeting_link')->nullable();
            $table->text('meeting_instructions')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('duration_weeks')->default(4);
            $table->unsignedInteger('estimated_hours')->default(10);
            $table->string('level')->default('All Levels');
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('course_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('content_type')->default('video'); // video, reading, live_session, quiz
            $table->string('video_provider')->default('youtube_unlisted'); // youtube_unlisted, vimeo, direct_url
            $table->string('video_id_or_url')->nullable();
            $table->longText('body_text')->nullable();
            $table->unsignedInteger('duration_minutes')->default(15);
            $table->string('meeting_link')->nullable();
            $table->boolean('is_free_preview')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('status')->default('active'); // active, completed, cancelled
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->string('payment_gateway')->default('free'); // paystack, squadco, free, admin_grant
            $table->string('payment_reference')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('certificate_id')->nullable()->constrained('certificates')->nullOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });

        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('course_enrollments')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('course_lessons')->cascadeOnDelete();
            $table->boolean('is_completed')->default(true);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['enrollment_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
        Schema::dropIfExists('course_enrollments');
        Schema::dropIfExists('course_lessons');
        Schema::dropIfExists('course_modules');
        Schema::dropIfExists('courses');
    }
};
