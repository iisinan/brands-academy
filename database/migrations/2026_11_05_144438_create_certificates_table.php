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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->string('verification_token')->unique();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workshop_application_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('recipient_name');
            $table->string('recipient_email');
            $table->string('course_title');
            $table->string('track_tier')->default('Certificate of Completion');
            $table->date('issued_at');
            $table->string('pdf_path')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->string('email_status')->default('pending'); // pending, sent, failed
            $table->text('email_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
