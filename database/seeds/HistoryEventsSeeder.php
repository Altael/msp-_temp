<?php

use Illuminate\Database\Seeder;

class HistoryEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = [
            [
                'name' => ["en" => "Opened svadhyaya", "ru" => "Открыл свадхьяю"],
                'slug' => 'svadhyaya-open'
            ],
            [
                'name' => ["en" => "Changed unit settings", "ru" => "Изменил настройки юнита"],
                'slug' => 'changed-settings-unit'
            ],
            [
                'name' => ["en" => "User registered", "ru" => "Пользователь зарегистрировался"],
                'slug' => 'user-registered'
            ],
            [
                'name' => ["en" => "User authenticated", "ru" => "Пользователь авторизировался"],
                'slug' => 'user-authenticated'
            ],
            [
                'name' => ["en" => "Call request opened", "ru" => "Запрос на звонок открыт"],
                'slug' => 'call-request-open'
            ],
            [
                'name' => ["en" => "Call request edited", "ru" => "Запрос на звонок изменен"],
                'slug' => 'call-request-edit'
            ],
            [
                'name' => ["en" => "Call request accepted by curator", "ru" => "Запрос на звонок принят куратором"],
                'slug' => 'call-request-edit-accept'
            ],
            [
                'name' => ["en" => "Call request forwarded to another curator", "ru" => "Запрос на звонок передан другому куратору"],
                'slug' => 'call-request-edit-forward'
            ],
            [
                'name' => ["en" => "Call request closed", "ru" => "Запрос на звонок закрыт"],
                'slug' => 'call-request-close'
            ],
            [
                'name' => ["en" => "User confirmed 100 hours of meditation", "ru" => "Пользователь сказал что намедитировал 100 часов"],
                'slug' => 'confirm-100-hours-of-meditation'
            ],
            [
                'name' => ["en" => "User started course", "ru" => "Пользователь открыл course"],
                'slug' => 'course-open'
            ],
            [
                'name' => ["en" => "User started course", "ru" => "Пользователь закрыл course"],
                'slug' => 'course-finish'
            ],
            [
                'name' => ["en" => "User started stage", "ru" => "Пользователь открыл stage"],
                'slug' => 'stage-open'
            ],
            [
                'name' => ["en" => "User finished stage", "ru" => "Пользователь закрыл stage"],
                'slug' => 'stage-finish'
            ],
            [
                'name' => ["en" => "User sent lesson request", "ru" => "Пользователь отправил заявку на урок"],
                'slug' => 'lesson-request-open'
            ],
            [
                'name' => ["en" => "Acarya gave lesson", "ru" => "Ачарья выдал урок"],
                'slug' => 'lesson-request-given'
            ],
            [
                'name' => ["en" => "Acarya rejected lesson request", "ru" => "Ачарья отклонил запрос"],
                'slug' => 'lesson-request-rejected'
            ],
            [
                'name' => ["en" => "Acarya cancelled a lesson", "ru" => "Ачарья отобрал урок"],
                'slug' => 'lesson-cancelled'
            ],
            [
                'name' => ["en" => "Lesson request was delegated to acarya", "ru" => "Запрос на урок был передан ачарье"],
                'slug' => 'lesson-request-delegated'
            ]
        ];


        foreach ($events as $event) {
            if(!\App\HistoryEventAction::where('slug', $event['slug'])->first()) {
                \App\HistoryEventAction::create([
                    'name' => $event['name'],
                    'slug' => $event['slug']
                ]);
            }
        }
    }
}
