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

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $areas = DistrictArea::all();

        for ($i = 1; $i <= 100; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '', // password
                'remember_token' => Str::random(10),
                'district_area_id' => $areas[rand(0, $areas->count()-1)]->id,
                'registration_completed' => true
            ]);

            $place = UserPlaces::firstOrCreate([
                'id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I',
                'name_en' => 'Lviv',
                'name_ru' => 'Львов'
            ]);

            $profile = UserProfile::create([
                'user_id' => $user->id,
                'first_name' => $faker->firstName,
                'middle_name' => $faker->userName,
                'last_name' => $faker->lastName,
                'phone' => $faker->phoneNumber,
                'spiritual_name' => $faker->userName,
                'birthday' => now(),
                'place_id' => 'ChIJV5oQCXzdOkcR4ngjARfFI0I'
            ]);

            $teacher = User::whereHas('roles', function ($query) {
                $query->where('slug', 'acarya');
            })->first();



            for ($j = 1; $j <= rand(1, 6); $j++) {
                LessonRequest::create([
                    'user_id' => $user->id,
                    'lesson' => $j,
                    'type' => 'get',
                    'status' => true,
                    'meditation_hours' => $j === 1 ? rand(100, 300) : 0,
                    'creation_date' => now()
                ]);

                MeditationLesson::create([
                    'user_id' => $user->id,
                    'from_user_id' => $teacher->id,
                    'lesson_number' => $j,
                    'receiving_date' => now()
                ]);


                if (rand(0,1)) {
                    LessonRequest::create([
                        'user_id' => $user->id,
                        'lesson' => $j,
                        'type' => 'check',
                        'status' => true,
                        'meditation_hours' => 0,
                        'creation_date' => now()
                    ]);
                }
            }

            UserTeacher::create([
                'user_id' => $user->id,
                'teacher_user_id' => $teacher->id
            ]);
        }
    }
}
