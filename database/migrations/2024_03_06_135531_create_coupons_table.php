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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('value')->unsigned();
            $table->boolean('active')->default(false);
            // price after sale
            $table->boolean('is_percentage')->default(false);
            $table->boolean('is_permanent')->default(false);
            $table->boolean('consumed')->default(false);

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
