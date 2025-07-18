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
        Schema::table('weather_observations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'archived', 'flagged'])->default('pending')->after('media_files');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weather_observations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
