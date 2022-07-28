<?php

use App\Models\Geolocation\DistrictArea;
use App\Models\User\User;
use App\Models\User\UserPlaces;
use Illuminate\Database\Seeder;

class DhirendraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area = DistrictArea::where('name', 'Lvov Oblast')->firstOrFail();



        $place = UserPlaces::create([
            'id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'name_en' => 'Lviv',
            'name_ru' => 'Львов'
        ]);

        /*Ачарья*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Дмитрий Лебедев',
            'email' => 'dc.lebedev@gmail.com',
            'registration_completed' => true
        ]);

        $user->socials()->create([
            'social_id' => '106981928279156244154',
            'provider' => 'google'
        ]);

        $profile = $user->profile()->create([
            'first_name' => 'Dmitrii',
            'middle_name' => 'SErgeevich',
            'last_name' => 'LEBEDEV',
            'sex' => 'male',
            'profession' => 'Web developer',
            'phone' => '2283122',
            'spiritual_name' => 'Dhirendra',
            'birthday' => '2001-01-06 00:00:00',
            'image' => '',
            'telegram_id' => '',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $user->roles()->sync([2, 5, 1, 8, 9, 10]);
    }
}
