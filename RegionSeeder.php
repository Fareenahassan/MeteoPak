<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['name' => 'Punjab'],
            ['name' => 'KPK'],
            ['name' => 'Azad Kashmir'],
            ['name' => 'Northern Areas'],
            ['name' => 'Sindh & Balochistan'],
            ['name' => 'Quetta'],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }

        $this->command->info('Regions seeded successfully.');
    }
}