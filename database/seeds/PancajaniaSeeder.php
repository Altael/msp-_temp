<?php

use Illuminate\Database\Seeder;

class PancajaniaSeeder extends Seeder
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
                'points' => -2
            ],
            [
                'name' => 'yes',
                'points' => 9
            ],
            [
                'name' => 'yes_and_sleep',
                'points' => 5
            ],

        ];

        foreach ($practiceItems as $practiceItem) {
            \App\Pancajania::create([
                'name'    => $practiceItem['name'],
                'points'  => $practiceItem['points']
            ]);
        }
    }
}
