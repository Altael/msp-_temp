<?php

use App\Models\Geolocation\DistrictArea;
use App\Models\MeditationLessons\LessonsRequests as LessonRequest;
use App\Models\MeditationLessons\MeditationLessons as MeditationLesson;
use App\Models\User\User;
use App\Models\User\UserPlaces;
use App\Models\User\UserProfile;
use App\Models\User\UserTeachers as UserTeacher;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class JyotindraSeeder extends Seeder
{
    public function run()
    {
        $area = DistrictArea::where('name', 'Lvov Oblast')->firstOrFail();


        /*Ачарья*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Евгений Цыбуля',
            'email' => 'sokrat@vip.dn.ua',
            'registration_completed' => true
        ]);

        $user->socials()->create([
            'social_id' => '102948013762291736807',
            'provider' => 'google'
        ]);

        $profile = $user->profile()->create([
           'first_name' => 'Yevhenii',
           'middle_name' => 'Alekseevich',
           'last_name' => 'Tsybulya',
           'sex' => 'male',
           'profession' => 'Looking for',
           'phone' => '+380674678253',
           'spiritual_name' => 'Jyotindra',
           'birthday' => '2001-01-06 00:00:00',
           'image' => 'https://imgur.com/Mg4s7od',
           'telegram_id' => '520866655',
           //'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
           'eula' => 1,
           'english' => 1
        ]);

        $user->roles()->sync([2, 5, 1, 8, 9, 10]);
    }
}
