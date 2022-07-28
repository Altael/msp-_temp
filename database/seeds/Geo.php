<?php

use App\Models\Geolocation\District;
use Illuminate\Database\Seeder;

class Geo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sector = \App\Models\Geolocation\Sector::create([
            'name' => 'Hong Kong'
        ]);

        $region = $sector->regions()->create([
            'name' => 'Moscow'
        ]);

        $diocese = $region->dioceses()->create([
            'name' => 'Moscow'
        ]);

        $diocese->districts()->createMany([
            ['name' => 'Moscow'],
            ['name' => 'Kazan'],
            ['name' => 'Nizhniy Novgorod'],
        ]);

        $diocese = $region->dioceses()->create([
            'name' => 'Kiev'
        ]);

        $diocese->districts()->createMany([
            ['name' => 'Kiev'],
            ['name' => 'Odessa'],
            ['name' => 'Kharkiv'],
            ['name' => 'Lviv'],
        ]);

        $district = District::where('name', 'Lviv')->firstOrFail();

        $district->districtAreas()->create([
            'name' => 'Lvov Oblast',
            'place_id' => 'ChIJb5xjPmndOkcRYj26h4iMDWM',
            'type' => 'region'
        ]);
    }
}
