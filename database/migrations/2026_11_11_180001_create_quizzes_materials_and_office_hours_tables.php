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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('course_module_id')->nullable()->constrained('course_modules')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('time_limit_minutes')->default(15);
            $table->unsignedInteger('pass_percentage')->default(80);
            $table->unsignedInteger('max_attempts')->default(3);
            $table->boolean('is_required_for_certificate')->default(true);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question_text');
            $table->text('explanation')->nullable();
            $table->unsignedInteger('points')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_question_id')->constrained('quiz_questions')->cascadeOnDelete();
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('course_enrollments')->cascadeOnDelete();
            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('total_points')->default(0);
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->boolean('passed')->default(false);
            $table->json('answers')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('course_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('course_module_id')->nullable()->constrained('course_modules')->nullOnDelete();
            $table->foreignId('course_lesson_id')->nullable()->constrained('course_lessons')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('file_type')->default('pdf'); // pdf, slides, template, sheet, zip, link
            $table->string('external_url')->nullable();
            $table->unsignedInteger('download_count')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('instructor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('instructor_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('day_of_week'); // monday, tuesday, wednesday, etc.
            $table->string('start_time'); // "14:00"
            $table->string('end_time'); // "16:00"
            $table->unsignedInteger('slot_duration_minutes')->default(20);
            $table->string('meeting_provider')->default('google_meet');
            $table->string('meeting_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('office_hour_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_schedule_id')->constrained('instructor_schedules')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('course_enrollments')->cascadeOnDelete();
            $table->date('booking_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->text('topic')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('status')->default('confirmed'); // confirmed, completed, cancelled
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_hour_bookings');
        Schema::dropIfExists('instructor_schedules');
        Schema::dropIfExists('course_resources');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
