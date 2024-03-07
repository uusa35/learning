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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("caption")->nullable();
            $table->string("image")->default("square.png");
            $table->string("keywords")->nullable();
            $table->smallInteger("order")->unsigned()->nullable();
            $table->boolean("active")->default(true);
            $table->morphs("imagable");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
