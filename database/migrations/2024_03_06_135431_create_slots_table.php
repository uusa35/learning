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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->time('start');
            $table->time('end');
            $table->string('color')->default('blue');
            $table->foreignId('day_id')->references('id')->on('days')->cascadeOnDelete()->unsigned();
            $table->foreignId('doctor_id')->references('id')->on('users')->cascadeOnDelete()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
