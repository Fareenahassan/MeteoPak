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
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('personal_number')->unique()->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->enum('designation', ['Director General', 'Chief Meteorologist', 'Director (Engineering) / Principal Engineer', 'Director / Principal Meteorologist', 'Senior Private Secretary', 'Deputy Director / Senior Meteorologist', 'Senior Programmer', 'Deputy Chief Administrative Officer', 'Sr. Electronic Engineer / Deputy Director (Engineering)', 'Administrative Officer', 'Meteorologist', 'Accounts Officer', 'Librarian', 'Security Officer', 'Electronics Engineer', 'Programmer', 'Assistant Meteorologist', 'Superintendent', 'Assistant Private Secretary', 'Assistant Programmer', 'Assistant Mechanical Engineer', 'Assistant Electronic Engineer', 'Head Draughtsman', 'Assistant Ministerial', 'Data Entry Operator', 'Meteorological Assistant', 'Stenotypist', 'Sub Engineer (Electronics)', 'Sub Engineer (Mechanical)', 'Mechanical Assistant', 'Draughtsman', 'Upper Division Clerk', 'Lower Division Clerk', 'Senior Observer', 'Observer'])->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->date('date_of_birth')->nullable();
            $table->string('profile_image')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('station_id')->references('id')->on('stations');
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