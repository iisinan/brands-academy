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
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('track_type')->default('workshop'); // cba, cbs, cbe, community, executive, workshop
            $table->string('tagline')->nullable();
            $table->text('description');
            $table->json('curriculum_topics')->nullable();
            $table->string('delivery_mode')->default('hybrid'); // online, in_person, hybrid
            $table->string('venue')->nullable();
            $table->string('fee_type')->default('free'); // free, subsidized, paid
            $table->decimal('fee_amount', 10, 2)->default(0.00);
            $table->unsignedInteger('capacity')->nullable();
            $table->dateTime('application_starts_at');
            $table->dateTime('application_deadline');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('instructor_name')->nullable();
            $table->string('status')->default('published'); // draft, published, closed, completed
            $table->boolean('is_featured')->default(false);
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
