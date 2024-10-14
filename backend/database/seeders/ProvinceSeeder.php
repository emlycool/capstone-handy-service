<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonString = file_get_contents(__DIR__ . '/seeds/provinces.json');
        $data = json_decode($jsonString);
        foreach ($data as $abbr => $province) {
            Province::updateOrCreate([
                'name' => $province
            ], [
                'code' => $abbr
            ]);
        }
    }
}
