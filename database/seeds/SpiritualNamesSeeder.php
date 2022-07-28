<?php

use Illuminate\Database\Seeder;

class SpiritualNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nameItems = [
            [
                'sanskrit'  => 'Jyotindra',
                'en'        => 'Jyotindra',
                'ru'        => 'Джотиндра',
                'desc_en'   => '',
                'desc_ru'   => '',
                'sex'       => 'male'
            ],
            [
                'sanskrit'  => 'Dhrti',
                'en'        => 'Dhrti',
                'ru'        => 'Дхрити',
                'desc_en'   => '',
                'desc_ru'   => '',
                'sex'       => 'female'
            ],
            [
                'sanskrit'  => 'Acyuta',
                'en'        => 'Acuyta',
                'ru'        => 'Ачьют',
                'desc_en'   => '',
                'desc_ru'   => '',
                'sex'       => 'male'
            ],
        ];

        foreach ($nameItems as $nameItem) {
            \App\SpiritualName::create([
                'sanskrit'  => $nameItem['sanskrit'],
                'en'        => $nameItem['en'],
                'ru'        => $nameItem['ru']
            ]);
        }
    }
}
