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
        Schema::create('public_weather_observations', function (Blueprint $table) {
            $table->id();
            $table->string('personal_name');
            $table->string('personal_phone');
            $table->string('personal_email');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('location_city');
            $table->string('location_state');
            $table->string('time_zone');
            $table->date('event_date');
            $table->time('event_time');
            $table->json('weather_types');
            $table->json('damages')->nullable();
            $table->text('event_description')->nullable();
            $table->json('media_files')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_weather_observations');
    }
};
