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
        Schema::create('service_filings', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('filing_type'); // cac_business_name, cac_company_ltd, trademark, patent, copyright
            $table->string('proposed_name_1');
            $table->string('proposed_name_2')->nullable();
            $table->string('proposed_name_3')->nullable();
            $table->text('business_nature')->nullable();
            $table->string('industry_category')->nullable();
            $table->text('business_address')->nullable();
            $table->string('headquarters_state')->nullable();
            $table->string('client_first_name');
            $table->string('client_last_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->string('client_nin')->nullable();
            $table->json('filing_data')->nullable(); // Class numbers, partners, directors, etc.
            $table->string('status')->default('payment_pending'); // payment_pending, submitted, search_in_progress, lodged_at_registry, queried, approved, delivered, rejected
            $table->decimal('total_fee', 12, 2)->default(0.00);
            $table->decimal('member_discount', 12, 2)->default(0.00);
            $table->decimal('fee_paid', 12, 2)->default(0.00);
            $table->string('payment_gateway')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('government_filing_number')->nullable();
            $table->string('official_certificate_path')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('client_query_message')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('filing_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_filing_id')->constrained()->cascadeOnDelete();
            $table->string('document_type'); // nin_slip, passport_photo, signature_specimen, trademark_logo, etc.
            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('filing_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_filing_id')->constrained()->cascadeOnDelete();
            $table->string('from_status');
            $table->string('to_status');
            $table->foreignId('changed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filing_status_logs');
        Schema::dropIfExists('filing_documents');
        Schema::dropIfExists('service_filings');
    }
};
