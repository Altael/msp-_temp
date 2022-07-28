<?php

use Illuminate\Database\Seeder;

class AsanasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $practiceItems = [
            [
                'name' => 'no',
                'points' => -10
            ],
            [
                'name' => 'period',
                'points' => 0
            ],
            [
                'name' => 'morning',
                'points' => 15
            ],
            [
                'name' => 'evening',
                'points' => 12
            ],
            [
                'name' => 'morning_and_evening',
                'points' => 32
            ],

        ];

        foreach ($practiceItems as $practiceItem) {
            \App\Asanas::create([
                'name'    => $practiceItem['name'],
                'points'  => $practiceItem['points']
            ]);
        }
    }
}
