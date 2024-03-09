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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('caption_ar')->nullable();
            $table->string('caption_en')->nullable();
            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();
            $table->mediumText('description_ar')->nullable();
            $table->mediumText('description_en')->nullable();
            $table->longText('aboutus_ar')->nullable();
            $table->longText('aboutus_en')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('country_ar')->nullable();
            $table->string('country_en')->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('email')->nullable();
            $table->string('android')->nullable();
            $table->string('apple')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('image')->nullable();
            $table->longText('policy_ar')->nullable();
            $table->longText('policy_en')->nullable();
            $table->longText('terms_ar')->nullable();
            $table->longText('terms_en')->nullable();
            $table->longText('services_ar')->nullable();
            $table->longText('services_en')->nullable();
            $table->string('color')->default('#1E3C97');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->longText('code')->nullable(); // for any scripts
            $table->boolean('grid_side_menu')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
