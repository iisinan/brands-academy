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
        Schema::table('members', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('status');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->decimal('paid_amount', 10, 2)->nullable()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('paid_amount');
            $table->string('payment_reference')->nullable()->after('paid_at');
            $table->string('payment_proof')->nullable()->after('payment_reference');
        });

        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->string('category');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('NGN');
            $table->string('payment_gateway')->default('paystack');
            $table->string('status')->default('pending');
            $table->string('gateway_reference')->nullable();
            $table->string('receipt_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_payments');

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_method',
                'paid_amount',
                'paid_at',
                'payment_reference',
                'payment_proof',
            ]);
        });
    }
};
