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

class DhrtiSeeder extends Seeder
{
    public function run()
    {
        /*$area = DistrictArea::create([
            'district_id' => 7,
            'name' => 'Lviv Oblast',
            'place_id' => 'ChIJb5xjPmndOkcRYj26h4iMDWM',
            'type' => 'region'
        ]);*/

        $area = DistrictArea::where('name', 'Lvov Oblast')->firstOrFail();

        $place = UserPlaces::create([
            'id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'name_en' => 'Lviv',
            'name_ru' => 'Львов'
        ]);

        /*Админ*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Татьяна Ц.',
            'email' => 'tiri@vip.dn.ua',
            'hidden' => true,
            'registration_completed' => true
        ]);

        $user->socials()->create([
            'social_id' => '110726614856493796860',
            'provider' => 'google'
        ]);

        $profile = $user->profile()->create([
           'first_name' => 'TestAdmin',
           'middle_name' => 'Админ',
           'last_name' => 'Google',
           'sex' => 'female',
           'profession' => 'Манагер',
           'phone' => '+380674678251',
           'spiritual_name' => 'Дхрити',
           'birthday' => '1979-04-12 00:00:00',
           'image' => 'https://lh3.googleusercontent.com/a-/AOh14GhhTKfUJVjtVfhjq1jKbKq3uQXPXfm-dIo_uHpDhw',
           'telegram_id' => '488096941',
           'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
           'eula' => 1,
           'english' => 1
        ]);

        $user->roles()->sync([1, 5]);

        /*Ачарья*/

        $userAcarya = User::create([
            'district_area_id' => $area->id,
            'name' => 'Ачарья',
            'email' => 'acarya@msp.com',
            'registration_completed' => true
        ]);

        $userAcarya->socials()->create([
            'social_id' => '223109502',
            'provider' => 'vkontakte'
        ]);

        $profile = $userAcarya->profile()->create([
            'first_name' => 'Диди',
            'middle_name' => 'Тест',
            'last_name' => 'Ачарья',
            'sex' => 'female',
            'profession' => 'тракторист',
            'phone' => '+380981917120',
            'spiritual_name' => 'Дхармарадждева',
            'birthday' => '1990-12-12 00:00:00',
            'image' => 'https://lh3.googleusercontent.com/a-/AOh14GhhTKfUJVjtVfhjq1jKbKq3uQXPXfm-dIo_uHpDhw',
            'telegram_id' => '1107147745',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $userAcarya->roles()->sync([5, 2]);

        UserTeacher::create([
            'user_id' => 2,
            'teacher_user_id' => 3
        ]);

        MeditationLesson::create([
            'user_id' => 2,
            'from_user_id' => 3,
            'lesson_number' => 1
        ]);

        $sector = \App\Models\Geolocation\Sector::first();

        $sector->acaryas()->attach($userAcarya->id);

        /*Секретарь*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Тетяна Цибуля',
            'hidden' => false,
            'registration_completed' => true
        ]);

        $user->socials()->create([
            'social_id' => '1087692104927648',
            'provider' => 'facebook'
        ]);

        $profile = $user->profile()->create([
            'first_name' => 'ТестФейсбук',
            'middle_name' => 'Тест',
            'last_name' => 'Секретарь',
            'sex' => 'female',
            'profession' => 'баньщик',
            'phone' => '+380678765432',
            'spiritual_name' => 'Мадху',
            'birthday' => '1980-12-12 00:00:00',
            'image' => 'https://graph.facebook.com/v3.3/1087692104927648/picture?type=normal',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $user->roles()->sync([5, 3]);

        /*Марги*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Марги Миша',
            'email' => 'margii@msp.com',
            'hidden' => true,
            'password' => '$2y$10$6ZvAx4vyMciI62rHdrJHxOuTBKSFhTH66O8Ilc6UWnyEKIiF6/hxm',
            'registration_completed' => true
        ]);



        $profile = $user->profile()->create([
            'first_name' => 'ТестЕмейл',
            'middle_name' => 'Тест',
            'last_name' => 'Марги',
            'sex' => 'male',
            'profession' => 'развозчик навоза',
            'phone' => '+380678765449',
            'spiritual_name' => 'Виджай',
            'birthday' => '1982-1-10 00:00:00',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $user->roles()->sync([5, 6]);

        /*Садхака*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Садхака Петя',
            'email' => 'sadhaka@msp.com',
            'hidden' => true,
            'password' => '$2y$10$6ZvAx4vyMciI62rHdrJHxOuTBKSFhTH66O8Ilc6UWnyEKIiF6/hxm',

            'registration_completed' => true
        ]);



        $profile = $user->profile()->create([
            'first_name' => 'ТестЕмейл',
            'middle_name' => 'Тест',
            'last_name' => 'Садхака',
            'sex' => 'male',
            'profession' => 'дояр',
            'phone' => '+380678765439',
            'spiritual_name' => 'Индраджит',
            'birthday' => '1985-11-10 00:00:00',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $user->roles()->sync([5]);

        /*Помощник*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Помощник',
            'email' => 'helper@msp.com',
            'hidden' => true,
            'password' => '$2y$10$6ZvAx4vyMciI62rHdrJHxOuTBKSFhTH66O8Ilc6UWnyEKIiF6/hxm',

            'registration_completed' => true
        ]);



        $profile = $user->profile()->create([
            'first_name' => 'Вася',
            'middle_name' => 'Тест',
            'last_name' => 'Помощник',
            'sex' => 'male',
            'profession' => 'дояр',
            'phone' => '+380678765432',
            'spiritual_name' => 'Алока',
            'birthday' => '1985-11-15 00:00:00',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $user->roles()->sync([5, 4]);

        $user->acaryas()->sync([$userAcarya->id]);

        /*bp*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'BP Коля',
            'email' => 'bp@msp.com',
            'hidden' => true,
            'password' => '$2y$10$6ZvAx4vyMciI62rHdrJHxOuTBKSFhTH66O8Ilc6UWnyEKIiF6/hxm',

            'registration_completed' => true
        ]);



        $profile = $user->profile()->create([
            'first_name' => 'Емейл',
            'middle_name' => 'Lyonya',
            'last_name' => 'BP',
            'sex' => 'male',
            'profession' => 'косар',
            'phone' => '+380678765433',
            'spiritual_name' => 'Махеш',
            'birthday' => '1985-11-17 00:00:00',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $user->roles()->sync([5, 7]);
    }
}
