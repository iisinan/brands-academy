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
        Schema::create('course_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('title')->nullable();
            $table->text('comment');
            $table->boolean('is_verified_learner')->default(true);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->unique(['course_id', 'user_id']);
        });

        Schema::create('lesson_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('course_lessons')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->longText('notes');
            $table->timestamps();

            $table->unique(['lesson_id', 'user_id']);
        });

        Schema::create('webinar_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained('webinars')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('attendee_name');
            $table->string('attendee_organization')->nullable();
            $table->text('question');
            $table->unsignedInteger('upvotes_count')->default(0);
            $table->boolean('is_answered')->default(false);
            $table->timestamps();

            $table->index(['webinar_id', 'upvotes_count']);
        });

        Schema::create('conference_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_id')->constrained('conferences')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_number')->default(1);
            $table->date('day_date')->nullable();
            $table->string('start_time');
            $table->string('end_time');
            $table->string('session_title');
            $table->text('session_description')->nullable();
            $table->string('speaker_name')->nullable();
            $table->string('speaker_role')->nullable();
            $table->string('hall_or_stream')->nullable();
            $table->string('track_type')->default('Keynote');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['conference_id', 'day_number', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_schedules');
        Schema::dropIfExists('webinar_questions');
        Schema::dropIfExists('lesson_notes');
        Schema::dropIfExists('course_reviews');
    }
};
