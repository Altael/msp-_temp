<?php

use App\Samgit;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = \App\MspSetting::create([
            'entity' => 'msp',
            'entity_id' => null,
            'dc_transcription_lang' => 'en',
            'dc_main_lang' => 'en',
            'standard_samgiits_type' => 'random',
            'standard_samgiits_amount' => 3,
            'standard_samgiits_list' => null
            //'standard_samgiits_list' => array_rand(array_flip(Samgit::where('premium', true)->pluck('id')->toArray()), 3)
        ]);
    }
}
