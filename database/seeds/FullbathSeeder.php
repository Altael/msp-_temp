<?php

use Illuminate\Database\Seeder;

class FullbathSeeder extends Seeder
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
                'name' => 'warm',
                'points' => 2
            ],
            [
                'name' => 'contrast',
                'points' => 3.5
            ],
            [
                'name' => 'cold',
                'points' => 5
            ],
        ];

        foreach ($practiceItems as $practiceItem) {
            \App\Fullbath::create([
                'name'    => $practiceItem['name'],
                'points'  => $practiceItem['points']
            ]);
        }
    }
}
