<?php

use App\Models\Geolocation\AcaryaGeo;
use App\Models\Geolocation\DistrictArea;
use App\Models\MeditationLessons\LessonsRequests as LessonRequest;
use App\Models\MeditationLessons\MeditationLessons as MeditationLesson;
use App\Models\User\User;
use App\Models\User\UserPlaces;
use App\Models\User\UserProfile;
use App\Models\User\UserTeachers as UserTeacher;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AsitimaSeeder extends Seeder
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

        /*Ачарья*/

        $acarya = User::create([
            'district_area_id' => $area->id,
            'name' => 'Оксана Вознюк',
            'email' => 'oksankavoznyuk@gmail.com',
            'registration_completed' => true
        ]);

        $acarya->socials()->create([
            'social_id' => '107321213020402084477',
            'provider' => 'google'
        ]);

        $profile = $acarya->profile()->create([
           'first_name' => 'Оксана',
           'middle_name' => 'Anatoliivna',
           'last_name' => 'Вознюк',
           'sex' => 'female',
           'profession' => 'Frontend development',
           'phone' => '+380685639242',
           'spiritual_name' => 'Asitima',
           'birthday' => '1993-12-14 00:00:00',
           'image' => 'https://lh3.googleusercontent.com/a-/AOh14GhYqJq0j371MUUerPw__65dyUXnBgMnRjuv1ymc7w',
           'telegram_id' => '',
           'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
           'eula' => 1,
           'english' => 1
        ]);

        $acarya->roles()->sync([2, 5, 1, 3, 6]);

        /*Садхака*/

        $user = User::create([
            'district_area_id' => $area->id,
            'name' => 'Oksana Vozniuk',
            'email' => 'oksaniavozniuk@gmail.com',

            'registration_completed' => true
        ]);

        UserTeacher::create([
            'user_id' => 3,
            'teacher_user_id' => 2
        ]);

        MeditationLesson::create([
            'user_id' => 3,
            'from_user_id' => 2,
            'lesson_number' => 1
        ]);

        $sector = \App\Models\Geolocation\Sector::first();

        $sector->acaryas()->attach($acarya->id);

        $user->acaryas()->sync([$acarya->id]);

        $user->socials()->create([
            'social_id' => '110006913986486912178',
            'provider' => 'google'
        ]);

        $profile = $user->profile()->create([
            'first_name' => 'Оксана',
            'middle_name' => 'Sadhaka',
            'last_name' => 'Вознюк',
            'sex' => 'female',
            'profession' => 'Frontend development',
            'phone' => '+380685639242',
            'spiritual_name' => 'Asitima',
            'birthday' => '1993-12-14 00:00:00',
            'image' => 'https://lh5.googleusercontent.com/-fMnNt40tdGc/AAAAAAAAAAI/AAAAAAAAAAA/AAKWJJPVF2M7AGmzn40qohsBelzspW0jAA/photo.jpg',
            'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
            'eula' => 1,
            'english' => 1
        ]);

        $user->roles()->sync([5, 4, 1]);
    }
}
