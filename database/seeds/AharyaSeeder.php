<?php

use Illuminate\Database\Seeder;

class AharyaSeeder extends Seeder
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
                'points' => 0
            ],
            [
                'name' => 'tamah',
                'points' => -7
            ],
            [
                'name' => 'rajah',
                'points' => -1
            ],
            [
                'name' => 'sattva_much',
                'points' => 2.5
            ],
            [
                'name' => 'sattva_norm',
                'points' => 5
            ],
        ];

        foreach ($practiceItems as $practiceItem) {
            \App\Aharya::create([
                'name'    => $practiceItem['name'],
                'points'  => $practiceItem['points']
            ]);
        }
    }
}
