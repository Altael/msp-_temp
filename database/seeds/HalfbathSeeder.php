<?php

use Illuminate\Database\Seeder;

class HalfbathSeeder extends Seeder
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
                'points' => -1
            ],
            [
                'name' => 'before_any',
                'points' => 1
            ],
            [
                'name' => 'before_sadhana_and_eat_or_sleep',
                'points' => 1.5
            ],
            [
                'name' => 'before_all',
                'points' => 2
            ],
        ];

        foreach ($practiceItems as $practiceItem) {
            \App\Halfbath::create([
                'name'    => $practiceItem['name'],
                'points'  => $practiceItem['points']
            ]);
        }
    }
}
