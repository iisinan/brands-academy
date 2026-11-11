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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('speaker_name');
            $table->string('speaker_title')->nullable();
            $table->text('speaker_bio')->nullable();
            $table->string('speaker_avatar')->nullable();
            $table->string('summary', 500)->nullable();
            $table->text('description')->nullable();
            $table->dateTime('starts_at');
            $table->unsignedInteger('duration_minutes')->default(60);
            $table->string('fee_type')->default('free'); // free, paid
            $table->decimal('regular_price', 10, 2)->default(0);
            $table->decimal('member_price', 10, 2)->default(0);
            $table->string('meeting_provider')->default('google_meet'); // google_meet, zoom, youtube_live
            $table->string('meeting_link')->nullable();
            $table->string('access_passcode')->nullable();
            $table->string('recording_url')->nullable();
            $table->string('status')->default('upcoming'); // upcoming, live, concluded, cancelled
            $table->unsignedInteger('max_attendees')->nullable();
            $table->string('banner_path')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('webinar_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained('webinars')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('organization')->nullable();
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->string('payment_gateway')->default('free');
            $table->string('payment_reference')->nullable();
            $table->boolean('attended')->default(false);
            $table->string('token')->unique();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();

            $table->unique(['webinar_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinar_registrations');
        Schema::dropIfExists('webinars');
    }
};
