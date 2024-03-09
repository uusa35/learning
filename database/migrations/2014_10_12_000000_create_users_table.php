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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('civil_id')->nullable();
            $table->string('nationality')->nullable();
            $table->date('dob');
            $table->enum('gender', ['male', 'femail'])->default('male');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->boolean('active')->default(true);
            $table->decimal('appointment_fees', 6, 2)->unsigned();
            $table->string('experience')->nullable();
            $table->enum('blood', ['A', 'B', 'A+', 'A-', 'AB', 'O-', 'O+', 'B+', 'B-', 'AB+', 'AB-']);
            $table->boolean('has_file')->default(false);
            $table->string('image')->default('user.png')->nullable();
            $table->string('notes')->nullable();
            $table->string('description_ar')->nullable();
            $table->string('description_en')->nullable();
            $table->string('signature')->nullable()->default(null);
            $table->string('api_token');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
