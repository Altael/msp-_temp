<?php

use Illuminate\Database\Seeder;

class UpavasaSeeder extends Seeder
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
                'points' => -3
            ],
            [
                'name' => 'juices_fruits',
                'points' => 2
            ],
            [
                'name' => 'water',
                'points' => 3
            ],
            [
                'name' => 'dry',
                'points' => 5
            ],
        ];

        foreach ($practiceItems as $practiceItem) {
            \App\Upavasa::create([
                'name'    => $practiceItem['name'],
                'points'  => $practiceItem['points']
            ]);
        }
    }
}
