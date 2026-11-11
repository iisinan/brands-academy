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
        Schema::create('journal_volumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('volume_number');
            $table->unsignedSmallInteger('year');
            $table->string('title')->nullable(); // e.g. "Volume 1 (2026)"
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('journal_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volume_id')->constrained('journal_volumes')->cascadeOnDelete();
            $table->unsignedSmallInteger('issue_number');
            $table->string('title')->nullable(); // e.g. "Special Issue on African Brand Equity & Market Signals"
            $table->date('published_date');
            $table->string('cover_image_path')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('journal_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->nullable()->constrained('journal_issues')->nullOnDelete();
            $table->foreignId('submitted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('abstract');
            $table->string('keywords')->nullable();
            $table->string('doi')->nullable();
            $table->string('manuscript_pdf_path')->nullable();
            $table->unsignedSmallInteger('page_start')->nullable();
            $table->unsignedSmallInteger('page_end')->nullable();
            $table->string('submission_status')->default('submitted'); // submitted, under_review, revision_required, accepted, published, declined
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('downloads_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('article_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('journal_articles')->cascadeOnDelete();
            $table->string('full_name');
            $table->string('affiliation');
            $table->string('email')->nullable();
            $table->string('orcid_id')->nullable();
            $table->boolean('is_corresponding')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->timestamps();
        });

        Schema::create('manuscript_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('journal_articles')->cascadeOnDelete();
            $table->foreignId('reviewer_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('recommendation')->nullable(); // accept, minor_revisions, major_revisions, reject
            $table->text('comments_for_authors')->nullable();
            $table->text('confidential_editorial_notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manuscript_reviews');
        Schema::dropIfExists('article_authors');
        Schema::dropIfExists('journal_articles');
        Schema::dropIfExists('journal_issues');
        Schema::dropIfExists('journal_volumes');
    }
};
