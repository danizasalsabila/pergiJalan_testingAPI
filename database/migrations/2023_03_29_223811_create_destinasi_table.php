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
        Schema::create('destinasi', function (Blueprint $table) {
            $table->id();
            $table->string('name_destinasi');
            $table->string('description');
            $table->string('address');
            $table->string('city');
            $table->string('category');
            $table->string('destination_picture')->nullable();
            $table->string('contact')->nullable();
            $table->string('hobby')->nullable();
            $table->string('rec_time')->nullable();
            $table->string('url_ticket')->nullable();
            $table->string('minutes_spend')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('url_map')->nullable();
            $table->string('rec_weather')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('open-hour')->nullable();
            $table->integer('closed-hour')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasi');
    }
};
