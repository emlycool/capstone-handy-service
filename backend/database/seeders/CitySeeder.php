<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonString = file_get_contents(__DIR__ . '/seeds/cities.json');
        $data = json_decode($jsonString);
        $provinces = Province::all()->pluck("id", "code");
        foreach ($data as [$cityName, $provinceCode]) {
            if(isset($provinces[$provinceCode])){
                $city = City::firstOrCreate([
                    'name' => $cityName,
                ], [
                    'province_id' => $provinces[$provinceCode]
                ]);
            }
        }
    }
}
