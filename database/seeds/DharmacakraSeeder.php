<?php

use Illuminate\Database\Seeder;

class DharmacakraSeeder extends Seeder
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
                'name' => 'participated',
                'points' => 7
            ],
            [
                'name' => 'had_duty',
                'points' => 8
            ],

        ];

        foreach ($practiceItems as $practiceItem) {
            \App\Dharmacakra::create([
                'name'    => $practiceItem['name'],
                'points'  => $practiceItem['points']
            ]);
        }
    }
}
