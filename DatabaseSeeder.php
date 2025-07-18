<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Order is important: regions must be created before stations,
        // and both must exist before creating users that reference them
        $this->call([
            RegionSeeder::class,
            StationSeeder::class,
            AdminSeeder::class,
        ]);
    }
}