<?php

namespace App\Console\Commands;

use App\Models\MeditationLessons\LessonsRequests;
use App\Models\MeditationLessons\MeditationLessons;
use App\Models\User\AcaryaHelper;
use App\Models\User\User;
use App\Models\User\UserPlaces;
use App\Models\User\UserTeachers;
use App\Services\Geolocation\FindDistrictAreaService;
use App\Services\Geolocation\UserPlacesService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use jeremykenedy\LaravelRoles\Models\Role;

class Import extends Command
{
    protected $signature = 'import';

    protected $description = 'Import data from old project';

    protected $places;

    public function handle(UserPlacesService $userPlacesService)
    {
        $this->places = $userPlacesService;

        $this->processUsers();

        $this->processNodes();
    }

    protected function processUsers()
    {
        $users = $this->getData();
        //dd($users['1552']);
        foreach ($users as $id => $user) {
            if (in_array('Acarya', $user['roles'])) {
                $this->addUser($user);
                unset($users[$id]);
            }
        }

        $i = 1;
        $total = count($users);

        foreach ($users as $id => $user) {
            echo "User ({$id}) - {$i}/{$total}\n\n";
            $this->addUser($user);
            $i++;
        }
    }

    protected function processNodes()
    {
        $nodes = $this->getNodes();

        $this->processLessons($nodes);
        $this->processChecks($nodes);
    }

    protected function processLessons($nodes)
    {
        foreach ($nodes['first'] as $lesson) {

            $user = User::findOrFail($lesson['uid']);

            LessonsRequests::firstOrCreate([
                'user_id' => $user->id,
                'lesson' => 1,
                'type' => 'get',
                'status' => !!$user->teacher,
                'meditation_hours' => intval($lesson['field_hours']['und'][0]['safe_value']),
                'creation_date' => Carbon::createFromTimestamp($lesson['created'])
            ]);

            if (!!$user->teacher) {
                MeditationLessons::firstOrCreate([
                    'user_id' => $user->id,
                    'from_user_id' => $user->teacher->id,
                    'lesson_number' => 1,
                    'receiving_date' => Carbon::createFromTimestamp($lesson['created'])
                ]);
            } else {
                echo "No teacher for : {$user->name} ({$user->id})\n";
            }

        }

        $lessonFields = [
            'field_second_lesson' => 2,
            'field_third_lesson' => 3,
            'field_fourth' => 4,
            'field_fifth' => 5,
            'field_sixth' => 6,
        ];

        foreach ($nodes['lessons'] as $lesson) {

            $user = User::findOrFail($lesson['uid']);

            foreach ($lessonFields as $field => $number) {

                if (!intval($lesson[$field]['und'][0]['value'] ?? 0)) continue;

                LessonsRequests::firstOrCreate([
                    'user_id' => $user->id,
                    'lesson' => $number,
                    'type' => 'get',
                    'status' => !!$user->teacher,
                    'meditation_hours' => 0,
                    'creation_date' => Carbon::createFromTimestamp($lesson['created'])
                ]);

                if (!!$user->teacher) {
                    MeditationLessons::firstOrCreate([
                        'user_id' => $user->id,
                        'from_user_id' => $user->teacher->id,
                        'lesson_number' => $number,
                        'receiving_date' => Carbon::createFromTimestamp($lesson['created'])
                    ]);
                } else {
                    echo "No teacher for : {$user->name} ({$user->id})\n";
                }
            }

        }

    }

    protected function processChecks($nodes)
    {
        $lessonFields = [
            'field_first_lesson' => 1,
            'field_second_lesson' => 2,
            'field_third_lesson' => 3,
            'field_fourth' => 4,
            'field_fifth' => 5,
            'field_sixth' => 6,
        ];

        foreach ($nodes['checks'] as $check) {
            $user = User::findOrFail($check['uid']);

            foreach ($lessonFields as $field => $number) {

                if (!intval($check[$field]['und'][0]['value'] ?? 0)) continue;

                LessonsRequests::firstOrCreate([
                    'user_id' => $user->id,
                    'lesson' => $number,
                    'type' => 'check',
                    'status' => true,
                    'meditation_hours' => 0,
                    'creation_date' => Carbon::createFromTimestamp($check['created'])
                ]);
            }
        }
    }

    protected function getData()
    {
        //$data = file_get_contents('https://personal.meditationsteps.org/export_xffz');
        $data = file_get_contents(storage_path('export_xffz.json'));
        $data = json_decode($data, true);

        return $data;
    }

    protected function getNodes()
    {
        //$data = file_get_contents('https://personal.meditationsteps.org/export_xffz_node');
        $data = file_get_contents(storage_path('export_xffz_node.json'));
        $data = json_decode($data, true);

        return $data;
    }

    protected function addUser($data)
    {
        $user = User::firstOrCreate([
            'id' => $data['uid']
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['mail'],
            'registration_completed' => true
        ]);

        if ($data['data']) {
            $user->socials()->firstOrCreate([
                'social_id' => $data['data']['hybridauth']['identifier'],
                'provider' => $this->provideMap($data['data']['hybridauth']['provider']),
            ]);
        }

        foreach ($data['roles'] as $item) {
            $slug = $this->roleMap($item);
            $role = Role::where('slug', $slug)->first();

            if ($role) {
                $user->roles()->syncWithoutDetaching($role->id);
            }
        }

        $profile = $user->profile()->firstOrCreate([]);

        $profile->update([
            'sex' => intval($data['field_sex']['und'][0]['value'] ?? 1) ? 'male' : 'female',
            'first_name' => $data['data']['hybridauth']['firstName'] ?? null,
            'last_name' => $data['data']['hybridauth']['lastName'] ?? null,
            'image' => $data['data']['hybridauth']['photoURL'] ?? null,
            'profession' => $data['field_occupation']['und'][0]['safe_value'] ?? null,
            'phone' => $data['field_phone']['und'][0]['safe_value'] ?? null,
            'spiritual_name' => $data['field_sanskrit']['und'][0]['safe_value'] ?? null,
            'birthday' => $data['field_birthday']['und'][0]['value'] ?? null,
        ]);

        if ($id = ($data['field_acarya']['und'][0]['uid'] ?? null)) {
            $acarya = User::find($id);

            if (!$acarya) {
                dd($data);
            }

            UserTeachers::firstOrCreate([
                'user_id' => $user->id,
                'teacher_user_id' => $acarya->id
            ]);
        }

        if ($id = ($data['field_helping_acarya']['und'][0]['uid'] ?? null)) {
            $acarya = User::find($id);

            AcaryaHelper::firstOrCreate([
                'acarya_id' => $acarya->id,
                'helper_id' => $user->id
            ]);
        }

        if (($city = ($data['field_city']['und'][0]['safe_value'] ?? null)) && !$profile->place_id) {

            echo "{$city}...\n";

            $result = $this->places->getPlaceByName($city);

            if ($result['status'] === 'OK') {
                $placeId = $result['predictions'][0]['place_id'];

                $en = $this->places->getPlaceNameByIdByLang($placeId, 'en');
                $ru = $this->places->getPlaceNameByIdByLang($placeId, 'ru');

                UserPlaces::firstOrCreate([
                    'id' => $placeId,
                    'name_en' => $en,
                    'name_ru' => $ru
                ]);

                $profile->update([
                    'place_id' => $placeId
                ]);

                echo "{$placeId} - {$en}/{$ru}\n-----------\n\n";
            }
        }
    }

    protected function provideMap($value)
    {
        $values = [
            'Facebook' => 'facebook',
            'Vkontakte' => 'vkontakte',
            'Google' => 'google',
            'Yandex' => 'yandex',
            'Mailru' => 'mailru',
        ];

        return $values[$value] ?? null;
    }

    protected function roleMap($value)
    {
        $values = [
            'authenticated user' => 'sadhaka',
            "Acarya's little helper" => 'helper',
            'Acarya' => 'acarya',
            //'Chief' => null,
            'administrator' => 'admin',

        ];

        return $values[$value] ?? null;
    }
}
