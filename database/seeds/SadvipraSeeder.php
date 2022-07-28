<?php

use Illuminate\Database\Seeder;

class SadvipraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campaigns = [
            [
                'name' => ["en" => "Sadvipra", "ru" => "Садвипра"],
                'description' => [
                    "en" => "For those who doesnt have lesson and follows the sadvipta path", "ru" => "Доступен для тех, кто не имеет урока и идет по пути садвипры"
                ],
                'slug' => 'sadvipra'
            ]
        ];

        foreach ($campaigns as $campaign) {
            if(!\App\Campaign::where('slug', $campaign['slug'])->first()) {
                \App\Campaign::create([
                    'name'    => $campaign['name'],
                    'description'    => $campaign['description'],
                    'slug'    => $campaign['slug']
                ]);
            }
        }

        $courses = [
            [
                'name' => ["en" => "About spiritual path", "ru" => "О духовном пути"],
                'description' => ["en" => "Before the first orientation", "ru" => "Перед первым собеседыванием"],
                'required' => true,
                'published' => true,
                'default_language' => 'ru',
                'order' => 1,
                'slug' => 'about-spiritual-path'
            ]
        ];

        foreach ($courses as $course) {
            if(!\App\Course::where('slug', $course['slug'])->first()) {
                \App\Course::create([
                    'name' => $course['name'],
                    'description' => $course['description'],
                    'required' => $course['required'],
                    'published' => $course['published'],
                    'default_language' => $course['default_language'],
                    'order' => $course['order'],
                    'slug' => $course['slug']
                ]);
            }
        }

        $stages = [
            [
                'course_id' => \App\Course::where('slug', 'about-spiritual-path')->first()->id,
                'name' => ["en" => "", "ru" => "Духовная практика"],
                'description' => ["en" => "", "ru" => ""],
                'videos' => ["https://drive.google.com/uc?export=view&id=1DVQ6cEi4gAOx6Z-Htg-Sb3SrhT7MmjXR#t=4"],
                'published' => true,
                'default_language' => 'ru',
                'order' => 1,
                'slug' => 'about-spiritual-path-1'
            ],
            [
                'course_id' => \App\Course::where('slug', 'about-spiritual-path')->first()->id,
                'name' => ["en" => "", "ru" => "Личные уроки"],
                'description' => ["en" => "", "ru" => ""],
                'videos' => ["https://drive.google.com/uc?export=view&id=18G3pLKo99X3o0P_BNS9rHq4nLMjHXyNN#t=4"],
                'published' => true,
                'default_language' => 'ru',
                'order' => 2,
                'slug' => 'about-spiritual-path-2'
            ],
            [
                'course_id' => \App\Course::where('slug', 'about-spiritual-path')->first()->id,
                'name' => ["en" => "", "ru" => "Подробнее о личных уроках"],
                'description' => ["en" => "", "ru" => ""],
                'videos' => ["https://drive.google.com/uc?export=view&id=1on1MNHWji_7qCPfTNKhnXmlzHZlIXjIU#t=4"],
                'published' => true,
                'default_language' => 'ru',
                'order' => 3,
                'slug' => 'about-spiritual-path-3'
            ],
            [
                'course_id' => \App\Course::where('slug', 'about-spiritual-path')->first()->id,
                'name' => ["en" => "", "ru" => "Учитель и Ученик"],
                'description' => ["en" => "", "ru" => ""],
                'videos' => ["https://drive.google.com/uc?export=view&id=1jq956bnP2irFcd-e5W3pFwhkHY5V99q5#t=4"],
                'published' => true,
                'default_language' => 'ru',
                'order' => 4,
                'slug' => 'about-spiritual-path-4'
            ]
        ];

        foreach ($stages as $stage) {
            if(!\App\Stage::where('slug', $stage['slug'])->first()) {
                \App\Stage::create([
                    'course_id' => $stage['course_id'],
                    'name' => $stage['name'],
                    'description' => $stage['description'],
                    'videos' => $stage['videos'],
                    'published' => $stage['published'],
                    'default_language' => $stage['default_language'],
                    'order' => $stage['order'],
                    'slug' => $stage['slug']
                ]);
            }
        }
    }
}
