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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start');
            $table->time('end');
            $table->foreignId('patient_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->references('id')->on('users')->cascadeOnDelete();

            $table->foreignId('created_by')->nullable();
            $table->enum('status', ['pending', 'canceled', 'complete', 'postponed']);
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
