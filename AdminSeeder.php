<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'asadghaffar.dev@gmail.com',
            'username' => 'enigmA',
            'password' => Hash::make('FrozenEnigma51@'),
            'personal_number' => null,
            'region_id' => null,
            'station_id' => null,
            'designation' => null,
            'gender' => 'Male',
            'status' => 'active',
            'role' => 'admin',
            'date_of_birth' => '2004-04-11',
            'description' => 'System administrator',
        ]);

        $this->command->info('Admin user created successfully.');
    }
}