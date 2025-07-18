<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get region IDs
        $punjabId = Region::where('name', 'Punjab')->first()->id;
        $kpkId = Region::where('name', 'KPK')->first()->id;
        $sindhBalochistanId = Region::where('name', 'Sindh & Balochistan')->first()->id;
        $azadKashmirId = Region::where('name', 'Azad Kashmir')->first()->id;
        $northernAreasId = Region::where('name', 'Northern Areas')->first()->id;
        $quettaId = Region::where('name', 'Quetta')->first()->id;

        // Define stations
        $stations = [
            // Punjab stations
            [
                'name' => 'Jhelum',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Faisalabad',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Bahawal Nagar',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Bahawal Pur',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Bahawal Pur (A/P)',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Bhakkar',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Noorpur Thal',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Jauharabad',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Khanpur',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Lahore A.P.',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Lahore PBO.',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Multan',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Mandi Bahauddin',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Sialkot',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Sialkot Airport',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Sargodha',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Toba Tek Sing',
                'region_id' => $punjabId
            ],
            [
                'name' => 'D.G. Khan',
                'region_id' => $punjabId
            ],
            [
                'name' => 'D.G. Khan (Aeromet)',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Jhang',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Mangla',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Sahiwal',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Chakwal',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Gujranwala',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Okara',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Rahim Yar Khan',
                'region_id' => $punjabId
            ],
            [
                'name' => 'Gujrat',
                'region_id' => $punjabId
            ],
            [
                'name' => 'MCC Lahore',
                'region_id' => $punjabId
            ],
            // KPK stations
            [
                'name' => 'Balakot',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Cherat',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Chitral',
                'region_id' => $kpkId
            ],
            [
                'name' => 'D.I.Khan (PBO)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'D.I.Khan (Aeromet)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Dir',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Drosh',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Kakul (Abbottabad)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Parachinar (PBO)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Parachinar (Aeromet)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Saidu Sharif (Aeromet Obsy)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Saidu Sharif (Met Obsy)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Kalam',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Malam Jabba',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Mir Khani',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Bannu',
                'region_id' => $kpkId
            ],
            [
                'name' => 'RMC Peshawar PBO',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Met Observatory Timergara (Lower Dir)',
                'region_id' => $kpkId
            ],
            [
                'name' => 'Met Observatory Pattan (Kohistan)',
                'region_id' => $kpkId
            ],
            // Sindh & Balochistan stations
            [
                'name' => 'PBO. Chhor',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'PBO. Hyderabad',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'PBO. Jiwani',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'PBO. Jacobabad',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O  S K.A.P.',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'PBO. Nawabshah',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'PBO. Panjgur',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'PBO. Pasni',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Badin',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Gwadar',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Larkana',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Lasbella',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Padidan',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Rohri',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'A.M. Moen-jo-daro',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'A.M. Ormara',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'A.M. Turbat',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'A.M. Sukkur',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'P.B.O / AER Karachi',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'Marine Met. Kiamari. Karachi',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Mithi',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'A.M. Tandojam',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O Dadu',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O Mirpur Khas',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'M.O. Thatta',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'A.M. Uthal',
                'region_id' => $sindhBalochistanId
            ],
            [
                'name' => 'A.M. Sakrand',
                'region_id' => $sindhBalochistanId
            ],
            // Azad Kashmir stations (placeholder - add actual stations when available)
            [
                'name' => 'Garhi Dupatta',
                'region_id' => $azadKashmirId
            ],
            [
                'name' => 'Kotli',
                'region_id' => $azadKashmirId
            ],
            [
                'name' => 'Rawalakot',
                'region_id' => $azadKashmirId
            ],
            [
                'name' => 'Muzaffarabad (P.B.O)',
                'region_id' => $azadKashmirId
            ],
            [
                'name' => 'Muzaffarabad (Aeromet)',
                'region_id' => $azadKashmirId
            ],
            // Northern Areas stations (placeholder - add actual stations when available)
            [
                'name' => 'Skardu (P.B.O)',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Skardu (A/P)',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Bunji',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Gilgit (P.B.O)',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Astore',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Chilas',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Gupis',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Hunza',
                'region_id' => $northernAreasId
            ],
            [
                'name' => 'Babusar',
                'region_id' => $northernAreasId
            ],
            // Quetta stations (placeholder - add actual stations when available)
            [
                'name' => 'P.B.O. , Sheikhmanda (Quetta)',
                'region_id' => $quettaId
            ],
            [
                'name' => 'R.A.M.C., Sariab Quetta',
                'region_id' => $quettaId
            ],
            [
                'name' => 'P.B.O., Kalat',
                'region_id' => $quettaId
            ],
            [
                'name' => 'P.B.O., Khuzdar',
                'region_id' => $quettaId
            ],
            [
                'name' => 'M.O., Sibbi',
                'region_id' => $quettaId
            ],
            [
                'name' => 'P.B.O., Zhob',
                'region_id' => $quettaId
            ],
            [
                'name' => 'P.B.O., Barkhan',
                'region_id' => $quettaId
            ],
            [
                'name' => 'P.B.O., Dalbandin',
                'region_id' => $quettaId
            ],
            [
                'name' => 'P.B.O., Nokkundi',
                'region_id' => $quettaId
            ],
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }

        $this->command->info('Stations seeded successfully.');
    }
}