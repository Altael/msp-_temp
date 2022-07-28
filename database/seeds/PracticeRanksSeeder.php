<?php

use Illuminate\Database\Seeder;
use App\PracticeRank;

class PracticeRanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PracticeRanksItems = [
            [
                'en' => 'Zombie',
                'ru' => 'ЗОМБИ',
                'points' => 0,
                'percent' => 0,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'Survivalist',
                'ru' => 'Выживающий',
                'points' => 37.5,
                'percent' => 0.19,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'On resort',
                'ru' => 'На отдыхе',
                'points' => 50.7,
                'percent' => 0.25,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'Alive',
                'ru' => 'Живой',
                'points' => 54.5,
                'percent' => 0.27,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'Puppy',
                'ru' => 'Щенок',
                'points' => 58.5,
                'percent' => 0.29,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'Homo Sapiens',
                'ru' => 'Хомо Сапиенс',
                'points' => 63.7,
                'percent' => 0.32,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'Baby',
                'ru' => 'Грудничок',
                'points' => 72.5,
                'percent' => 0.36,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'Mother\'s boy',
                'ru' => 'Маменькин сынок',
                'points' => 75.6,
                'percent' => 0.38,
                'guna' => 'Tamah',
            ],
            [
                'en' => 'Youngster',
                'ru' => 'Юнец',
                'points' => 80.15,
                'percent' => 0.4,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Frisky',
                'ru' => 'Резвый',
                'points' => 84.78,
                'percent' => 0.42,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Ringleader',
                'ru' => 'Заводила',
                'points' => 96.3,
                'percent' => 0.48,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Rebel',
                'ru' => 'Бунтарь',
                'points' => 102.85,
                'percent' => 0.51,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Pioneer',
                'ru' => 'Пионер',
                'points' => 109.42,
                'percent' => 0.55,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Fearless',
                'ru' => 'Бесстрашный',
                'points' => 114,
                'percent' => 0.57,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Chieftain',
                'ru' => 'Вождь',
                'points' => 118,
                'percent' => 0.59,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Leader',
                'ru' => 'Лидер',
                'points' => 123.5,
                'percent' => 0.62,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Innovator',
                'ru' => 'Новатор',
                'points' => 128.2,
                'percent' => 0.64,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Monarch',
                'ru' => 'Монарх',
                'points' => 132.5,
                'percent' => 0.66,
                'guna' => 'Rajah',
            ],
            [
                'en' => 'Sorcerer',
                'ru' => 'Чародей',
                'points' => 136.2,
                'percent' => 0.68,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Sage',
                'ru' => 'Мудрец',
                'points' => 142.7,
                'percent' => 0.71,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Yogi',
                'ru' => 'Йогин',
                'points' => 148.85,
                'percent' => 0.74,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Bhakta',
                'ru' => 'Бхакта',
                'points' => 153.7,
                'percent' => 0.77,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Sadvipra',
                'ru' => 'Садвипра',
                'points' => 161.9,
                'percent' => 0.81,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Messiah',
                'ru' => 'Мессия',
                'points' => 168.78,
                'percent' => 0.84,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Demigod',
                'ru' => 'Полубог',
                'points' => 173.78,
                'percent' => 0.87,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Absolute god',
                'ru' => 'Бог во плоти',
                'points' => 183.2,
                'percent' => 0.92,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Guru',
                'ru' => 'Гуру',
                'points' => 192.3,
                'percent' => 0.96,
                'guna' => 'Sattva',
            ],
            [
                'en' => 'Guru',
                'ru' => '',
                'points' => 200,
                'percent' => 1,
                'guna' => 'Sattva',
            ],
        ];

        foreach ($PracticeRanksItems as $PracticeRanksItem) {
            PracticeRank::create([
                'en'    => $PracticeRanksItem['en'],
                'ru'    => $PracticeRanksItem['ru'],
                'points'  => $PracticeRanksItem['points'],
                'percent'    => $PracticeRanksItem['percent'],
                'guna'    => $PracticeRanksItem['guna'],
            ]);
        }

    }
}
