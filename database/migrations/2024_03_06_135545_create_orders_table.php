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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'paid', 'failed', 'under_process', 'completed', 'delivered', 'canceled', 'unknown', 'success'])->nullable()->default('pending');
            $table->boolean('paid')->default(false);
            $table->decimal('total', 6, 2)->unsigned();
            $table->decimal('discount', 6, 2)->unsigned()->default(0); //
            $table->decimal('net_total', 6, 2)->unsigned(); // used if coupon code exists
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->mediumText('notes')->nullable();
            $table->string('reference_id')->deafult('0');
            $table->enum('payment_method', ['knet', 'visa', 'cash'])->nullable();
            $table->string('payment_provider_response')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->constrained('users')->unsigned();
            $table->foreignId('appointment_id')->nullable()->constrained();
            $table->foreignId('created_by')->nullable()->constrained();
            $table->date('expires_at')->nullable();
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
