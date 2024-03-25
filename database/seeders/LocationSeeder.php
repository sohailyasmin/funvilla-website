<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            ['name' => 'London'],
            ['name' => 'Canada'],
          
        ];

        foreach ($locations as $locationData) {
           
            $locationData['slug'] = Str::slug($locationData['name']);

            Location::create($locationData);
        }
    }
}
