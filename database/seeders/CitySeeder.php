<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Banjarmasin',
                'slug' => 'banjarmasin',
                'image' => 'cities/banjarmasin.jpg',
            ],
            [
                'name' => 'Banjarbaru',
                'slug' => 'banjarbaru',
                'image' => 'cities/banjarbaru.jpg',
            ],
            [
                'name' => 'Martapura',
                'slug' => 'martapura',
                'image' => 'cities/martapura.jpg',
            ],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}