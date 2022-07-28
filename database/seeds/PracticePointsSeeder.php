<?php

use Illuminate\Database\Seeder;
use App\PracticePoint;

class PracticePointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Practise names and their worth

        $PracticePointsItems = [
            [
                'name'      => 'lalita_marmika',
                'points'    => 14,
                'time'      => 2,
                'fee'       => -5
            ],
            [
                'name'      => 'lalita_marmika_time',
                'points'    => 26.5,
                'time'      => 1,
                'fee'       => -5
            ],
            [
                'name'      => 'meditation',
                'points'    => 18,
                'time'      => 2,
                'fee'       => -9
            ],
            [
                'name'      => 'meditation_time',
                'points'    => 20,
                'time'      => 2,
                'fee'       => -9
            ],
            [
                'name'      => 'karma_yoga',
                'points'    => 20,
                'time'      => 1,
                'fee'       => -1
            ],
            [
                'name'      => 'dances',
                'points'    => 16,
                'time'      => 0.25,
                'fee'       => -1
            ],
            [
                'name'      => 'svadhyaya',
                'points'    => 13,
                'time'      => 0.5,
                'fee'       => -1
            ],
            [
                'name'      => 'diary',
                'points'    => 6.5,
                'time'      => 1,
                'fee'       => -1
            ],
        ];

        foreach ($PracticePointsItems as $PracticePointsItem) {
            PracticePoint::create([
                'name'    => $PracticePointsItem['name'],
                'points'  => $PracticePointsItem['points'],
                'time'    => $PracticePointsItem['time'],
                'fee'    => $PracticePointsItem['fee'],
            ]);
        }

    }
}
