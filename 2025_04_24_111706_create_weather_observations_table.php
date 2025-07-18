<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('weather_observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_name');
            $table->string('personal_number');
            $table->string('designation');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('location_city');
            $table->string('location_state');
            $table->string('time_zone');
            $table->date('event_date');
            $table->time('event_time');
            $table->json('weather_types');
            $table->json('damages')->nullable();
            $table->text('event_description')->nullable();
            $table->json('media_files')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_observations');
    }
}; 