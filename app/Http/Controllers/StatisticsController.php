<?php

namespace App\Http\Controllers;

use App\Http\Resources\DistrictAreaInfoResource;
use App\Http\Resources\ProgramsResource;
use App\Http\Resources\UnitInfoResource;
use App\Http\Resources\UnitStatisticsResourse;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Models\Geolocation\District;
use App\Models\Geolocation\DistrictArea;
use App\Models\Geolocation\Unit;
use App\Models\MeditationLessons\LessonsRequests;
use App\Models\MeditationLessons\MeditationLessons;
use App\Models\User\User;
use App\Program;
use App\Repositories\User\UserRepository;
use App\UnitProgram;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class StatisticsController extends Controller
{
    public function index(UserRepository $userRepository)
    {
        $acaryas = [];

        if(auth()->user()->hasRole('admin')) {
            $acaryas = UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0));
        }

        return ['acaryas' => $acaryas];

    }

    public function table()
    {
        $acaryas = User::whereHas('roles', function ($q) {
            $q->where('roles.slug', 'acarya');
        })->get();

        $lessons = [];

        $lessons['all']['all'][1] = 0;
        $lessons['all']['all'][2] = 0;
        $lessons['all']['all'][3] = 0;
        $lessons['all']['all'][4] = 0;
        $lessons['all']['all'][5] = 0;
        $lessons['all']['all'][6] = 0;

        $checks = [];

        foreach($acaryas as $acarya) {
            $data = MeditationLessons::select(\DB::raw("(COUNT(*)) as count"),
                \DB::raw("DATE_FORMAT(receiving_date, '%c') as month"),
                \DB::raw("DATE_FORMAT(receiving_date, '%Y') as year"),
                'lesson_number')
                ->whereDate('receiving_date', '>=', request('start'))
                ->whereDate('receiving_date', '<=', request('end'))
                ->where('from_user_id', $acarya->id)
                ->latest('receiving_date')
                ->groupBy('year', 'month', 'lesson_number')
                ->get();

            $lessons[$acarya->display_name]['all'][1] = 0;
            $lessons[$acarya->display_name]['all'][2] = 0;
            $lessons[$acarya->display_name]['all'][3] = 0;
            $lessons[$acarya->display_name]['all'][4] = 0;
            $lessons[$acarya->display_name]['all'][5] = 0;
            $lessons[$acarya->display_name]['all'][6] = 0;

            foreach($data as $row) {
                $lessons[$acarya->display_name]['all'][$row->lesson_number] += $row->count;
                $lessons[$acarya->display_name][$row->year . '_' . $row->month][$row->lesson_number] = $row->count;
                $lessons['all'][$row->year . '_' . $row->month][$row->lesson_number] = $lessons['all'][$row->year . '_' . $row->month][$row->lesson_number] ?? 0 + $row->count;
                $lessons['all']['all'][$row->lesson_number] += $row->count;
            }

            $data = LessonsRequests::select(\DB::raw("(COUNT(*)) as count"),
                \DB::raw("DATE_FORMAT(lessons_requests.updated_at, '%c') as month"),
                \DB::raw("DATE_FORMAT(lessons_requests.updated_at, '%Y') as year"))
                ->join('users_teachers as ut', 'ut.user_id', '=', 'lessons_requests.user_id')
                ->where('ut.teacher_user_id', '=', $acarya->id)
                ->where('status', true)
                ->where('type', 'check')
                ->whereDate('lessons_requests.updated_at', '>=', request('start'))
                ->whereDate('lessons_requests.updated_at', '<=', request('end'))
                ->groupBy('year', 'month')
                ->get()->toArray();

            $checks[$acarya->display_name] = [];

            foreach($data as $row) {
                $checks[$acarya->display_name][$row['year'] . '_' . $row['month']] = $row['count'];
                $checks['all'][$row['year'] . '_' . $row['month']] = ($checks['all'][$row['year'] . '_' . $row['month']] ?? 0) + $row['count'];
            }
        }

        return [
            'lessons' => $lessons,
            'checks' => $checks
        ];
    }

    public function lessons()
    {
        $given = [
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
        ];

        $checked = [
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
        ];

        $user = request('id') ? User::find(request('id')) : auth()->user();

        if($user->hasRole('admin') && !request('id')) {
            $query = LessonsRequests::join('users', 'users.id', '=', 'lessons_requests.user_id')
                ->where('users.hidden', '=', 0)
                ->where('status', true)
                ->where('lessons_requests.updated_at', '>=', request('start'))
                ->where('lessons_requests.updated_at', '<=', request('end'))
                ->where('lesson', '>', 1);
            $cloned = clone $query;
        } else if($user->hasRole('acarya')) {
            $query = LessonsRequests::query()
                ->join('users_teachers as ut', 'ut.user_id', '=', 'lessons_requests.user_id')
                ->where('ut.teacher_user_id', '=', $user->id)
                ->where('lessons_requests.status', true)
                ->where('lessons_requests.updated_at', '>=', request('start'))
                ->where('lessons_requests.updated_at', '<=', request('end'))
                ->where('lessons_requests.lesson', '>', 1);
            $cloned = clone $query;
        }

        $lessons = $query->where('type', 'get')
            ->groupBy('lessons_requests.user_id' ,'lesson')
            ->get();

        $checks = $cloned->where('type', 'check')
            ->get();

        foreach ($lessons as $lesson) {
            $number = $lesson->lesson;
            $given[$number] += 1;
        }
        foreach ($checks as $check) {
            $number = $check->lesson;
            $checked[$number] += 1;
        }


        return [
            'labels' => ['Урок 2', 'Урок 3', 'Урок 4', 'Урок 5', 'Урок 6'],
            'datasets' => [
                [
                    'label' => 'Выдано',
                    'data' => array_values($given),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    'borderWidth' => 1
                ],

                [
                    'label' => 'Проверено',
                    'data' => array_values($checked),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    public function initiations()
    {
        $given = [
            1 => 0
        ];

        $checked = [
            1 => 0
        ];

        $user = request('id') ? User::find(request('id')) : auth()->user();
        if($user->hasRole('admin') && !request('id')) {
            $query = LessonsRequests::join('users', 'users.id', '=', 'lessons_requests.user_id')
                ->where('users.hidden', '=', 0)
                ->where('status', true)
                ->where('lessons_requests.updated_at', '>=', request('start'))
                ->where('lessons_requests.updated_at', '<', request('end'))
                ->where('lesson', 1);
            $cloned = clone $query;
        } else if($user->hasRole('acarya')) {
            $query = LessonsRequests::query()
                ->join('users_teachers as ut', 'ut.user_id', '=', 'lessons_requests.user_id')
                ->where('ut.teacher_user_id', '=', $user->id)
                ->where('lessons_requests.status', true)
                ->where('lessons_requests.updated_at', '>=', request('start'))
                ->where('lessons_requests.updated_at', '<', request('end'))
                ->where('lessons_requests.lesson', 1);
            $cloned = clone $query;
        }

        $given[1] = $query->where('type', 'get')
            ->distinct('lessons_requests.user_id')
            ->count('lessons_requests.user_id');

        $checked[1] = $cloned->where('type', 'check')
            ->count();

        return [
            'datasets' => [[
                'data' => [$given[1], $checked[1]],
                'backgroundColor' => [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ]]
            ],


            'labels' => [
                'Инициаций',
                'Проверок',
            ],

            'name' => $user->profile ? $user->profile->displayName : $user->name
        ];
    }

    public function getUnitsEvents() {
        $entity = request('entity');
        $user = auth()->user();

        if($entity === 'bhukti') {
            if($user->hasRole('admin')) {
                $units = Unit::with('district')->get();
            } else {
                $units = $user->bpUnits;
            }
        } else {
            $units = [$user->unit];
        }

        $districts = [];

        foreach($units as $unit) {
            $district_name = $unit->district->name;

            if($unit->has('events')) {
                $events = $unit->events()
                    ->where('date', '>=', request('start'))
                    ->where('date', '<=', request('end'))
                    ->with('users')
                    ->orderByDesc('date')
                    ->get();

                $unique_members = $events->pluck('users')->flatten()->unique('id');

                $ini = 0;
                $not_ini = 0;

                foreach ($unique_members as $user) {
                    if($user->has('lessons')) {
                        $ini++;
                    } else {
                        $not_ini++;
                    }
                }

                $districts[$district_name]['units'][$unit->name] = [
                    'unique_ini' => $ini,
                    'unique_not_ini' => $not_ini
                ];

                foreach($events as $event) {
                    $districts[$district_name]['units'][$unit->name]['events'][$event->program->name][] = new UnitStatisticsResourse($event);

                    $districts[$district_name]['events'][$event->program->name][] = new UnitStatisticsResourse($event);
                }

                $districts[$district_name]['unique_ini'] = ($districts[$district_name]['unique_ini'] ?? 0) + $ini;
                $districts[$district_name]['unique_not_ini'] = ($districts[$district_name]['unique_not_ini'] ?? 0) + $not_ini;
            }

            $active_members = $unit->active_members();
            $districts[$district_name]['units'][$unit->name]['active_ini'] = $active_members['ini'];
            $districts[$district_name]['units'][$unit->name]['active_not_ini'] = $active_members['not_ini'];
            $districts[$district_name]['units'][$unit->name]['activity_period'] = $unit->settings->active_member_quota;
            $districts[$district_name]['units'][$unit->name]['id'] = $unit->id;

            $districts[$district_name]['active_ini'] = ($districts[$district_name]['active_ini'] ?? 0) + $active_members['ini'];
            $districts[$district_name]['active_not_ini'] = ($districts[$district_name]['active_not_ini'] ?? 0) + $active_members['not_ini'];
        }

        foreach($districts as $district_name => $district) {
            if(isset($district['events'])) {
                foreach ($district['events'] as $index => $event_group) {
                    usort($districts[$district_name]['events'][$index], function ($a, $b) {
                        if ($a['date'] === $b['date']) return 0;

                        return (new Carbon($a['date']))->gt(new Carbon($b['date'])) ? -1 : 1;
                    });
                }
            }
        }

        return [
            'districts' => $districts
        ];
    }

    public function getEventsReport()
    {

        $user = auth()->user();

        $regions = [];

        $events = ProgramsResource::collection(Program::orderByDesc('vip')->orderBy('order')->get());

        $periods = [];

        $periods_request = [];

        forEach(request('periods') as $index => $period) {
            $periods_request[$index] = json_decode($period)->day;
        }

        foreach($periods_request as $key => $monday) {
            $periods[$key]['start'] = Carbon::parse($monday)->format('Y.m.d');
            $periods[$key]['end'] = Carbon::parse($monday)->endOf(request('mode'))->format('Y.m.d');
        }



        if($user->hasRole('bc|admin|acb|vmtr')) {
            $programs=[];

            $full_map = json_decode(json_encode(\DB::select('
            SELECT
reg.name AS region,
dio.name AS diocese,
dis.name AS bhukti,
di.name AS area,
u.name AS unit

FROM districts dis

LEFT JOIN dioceses dio ON dis.diocese_id = dio.id
LEFT JOIN regions reg ON dio.region_id = reg.id

LEFT JOIN district_areas di ON dis.id = di.district_id
LEFT JOIN units u ON di.id = u.district_area_id')), true);

            foreach($periods as $key => $period) {

                $units = [];

                $main_info = json_decode(json_encode(\DB::select('
            SELECT
reg.name as region,
dis.name AS bhukti,
dis.id AS bhukti_id,
u.name AS unit,
p.slug AS practice_name,
SUM(up_ini.initiated_guests) AS guests_ini,
SUM(up_ini.not_initiated_guests) AS guests_not_ini

FROM districts dis

JOIN dioceses dio ON dis.diocese_id = dio.id
JOIN regions reg ON dio.region_id = reg.id

JOIN district_areas di ON dis.id = di.district_id
JOIN units u ON di.id = u.district_area_id

JOIN units_programs up_ini ON up_ini.unit_id = u.id

JOIN programs p ON up_ini.program_id = p.id

WHERE up_ini.date >= ?
AND up_ini.date <= ?

GROUP BY region, bhukti, unit, practice_name', [$period['start'], $period['end']])), true);

                foreach ($main_info as $key_1 => $record) {
                    $main_info[$record['unit'] . '_' . $record['practice_name']] = $record;
                    unset($main_info[$key_1]);
                }

                $members_ini = \DB::select('
            SELECT
u.name AS unit,
p.slug AS practice_name,

COUNT(uup_ini.id) AS ini_members_count

FROM units u

JOIN units_programs up_ini ON up_ini.unit_id = u.id
LEFT JOIN users_units_programs uup_ini ON up_ini.id = uup_ini.unit_program_id
JOIN meditation_lessons ml1 ON uup_ini.user_id = ml1.user_id

JOIN programs p ON up_ini.program_id = p.id

WHERE up_ini.date >= ?
AND up_ini.date <= ?
AND ml1.lesson_number = 1

GROUP BY unit, practice_name', [$period['start'], $period['end']]);

                foreach ($members_ini as $key_2 => $record) {
                    $main_info[$record->unit . '_' . $record->practice_name]['members_ini'] = $record->ini_members_count;
                    unset($members_ini[$key_2]);
                }

                $members = \DB::select('
            SELECT
u.name AS unit,
p.slug AS practice_name,

COUNT(uup.id) AS members_count

FROM units u

JOIN units_programs up ON up.unit_id = u.id
LEFT JOIN users_units_programs uup ON up.id = uup.unit_program_id

JOIN programs p ON up.program_id = p.id

WHERE up.date >= ?
AND up.date <= ?

GROUP BY unit, practice_name', [$period['start'], $period['end']]);

                foreach ($members as $key_3 => $record) {
                    $main_info[$record->unit . '_' . $record->practice_name]['members_not_ini'] = $record->members_count - ($main_info[$record->unit . '_' . $record->practice_name]['members_ini'] ?? 0);
                    unset($members[$key_3]);
                }

                $programs[$period['start'] . '_' . $period['end']] = $main_info;
            }

            foreach($programs as $period => $record) {
                foreach($record as $program) {

                    $bhukti = District::find($program['bhukti_id']);

                    $regions[$program['region']][$program['bhukti']]['acarya'] = $bhukti->curator_acarya ? $bhukti->curator_acarya->profile->display_name : '';
                    $regions[$program['region']][$program['bhukti']]['bp'] = $bhukti->bp() ? $bhukti->bp()->profile->display_name : '';

                    $unit = Unit::where('name', $program['unit'])->first();

                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']]['active_members']['left'] = $unit->active_members_custom(request('left_start'), request('left_end'));
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']]['active_members']['right'] = $unit->active_members_custom(request('right_start'), request('right_end'));

                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['ini']['users'] = $program['members_ini'] ?? 0;
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['ini']['guests'] = $program['members_not_ini'];
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['not_ini']['users'] = (integer)$program['guests_ini'];
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['not_ini']['guests'] = (integer)$program['guests_not_ini'];
                }
            }

            foreach($full_map as $place) {
                if($place['unit']) {
                    if(!isset($regions[$place['region']][$place['bhukti']]['units'][$place['unit']])) {
                        $regions[$place['region']][$place['bhukti']]['units'][$place['unit']] = [];
                    }
                } else {
                    if(!isset($regions[$place['region']][$place['bhukti']])) {
                        $regions[$place['region']][$place['bhukti']] = [
                            'units' => []
                        ];
                    }
                }
            }
        } else if($user->hasRole('bp')) {
            if(count($user->bpDistricts)) {
                $bhuktis = implode(',', $user->bpDistricts->pluck('id')->toArray());

                $programs = [];

                foreach ($periods as $key => $period) {

                    $main_info = json_decode(json_encode(\DB::select("
            SELECT
reg.name as region,
dis.name AS bhukti,
dis.id AS bhukti_id,
u.name AS unit,
p.slug AS practice_name,
SUM(up_ini.initiated_guests) AS guests_ini,
SUM(up_ini.not_initiated_guests) AS guests_not_ini

FROM districts dis

JOIN dioceses dio ON dis.diocese_id = dio.id
JOIN regions reg ON dio.region_id = reg.id

JOIN district_areas di ON dis.id = di.district_id
JOIN units u ON di.id = u.district_area_id

JOIN units_programs up_ini ON up_ini.unit_id = u.id

JOIN programs p ON up_ini.program_id = p.id

WHERE up_ini.date >= ?
AND up_ini.date <= ?
AND dis.id IN ({$bhuktis})

GROUP BY region, bhukti, unit, practice_name", [$period['start'], $period['end']])), true);

                    foreach ($main_info as $key_1 => $record) {
                        $main_info[$record['unit'] . '_' . $record['practice_name']] = $record;
                        unset($main_info[$key_1]);
                    }

                    $members_ini = \DB::select("
            SELECT
u.name AS unit,
p.slug AS practice_name,

COUNT(uup_ini.id) AS ini_members_count

FROM units u

JOIN district_areas da ON u.district_area_id = da.id
JOIN districts dis ON da.district_id = dis.id

JOIN units_programs up_ini ON up_ini.unit_id = u.id
LEFT JOIN users_units_programs uup_ini ON up_ini.id = uup_ini.unit_program_id
JOIN meditation_lessons ml1 ON uup_ini.user_id = ml1.user_id

JOIN programs p ON up_ini.program_id = p.id

WHERE up_ini.date >= ?
AND up_ini.date <= ?
AND ml1.lesson_number = 1
AND dis.id IN ({$bhuktis})

GROUP BY unit, practice_name", [$period['start'], $period['end']]);

                    foreach ($members_ini as $key_2 => $record) {
                        $main_info[$record->unit . '_' . $record->practice_name]['members_ini'] = $record->ini_members_count;
                        unset($members_ini[$key_2]);
                    }

                    $members = \DB::select("
            SELECT
u.name AS unit,
p.slug AS practice_name,

COUNT(uup.id) AS members_count

FROM units u

JOIN district_areas da ON u.district_area_id = da.id
JOIN districts dis ON da.district_id = dis.id

JOIN units_programs up ON up.unit_id = u.id
LEFT JOIN users_units_programs uup ON up.id = uup.unit_program_id

JOIN programs p ON up.program_id = p.id

WHERE up.date >= ?
AND up.date <= ?
AND dis.id IN ({$bhuktis})

GROUP BY unit, practice_name", [$period['start'], $period['end']]);

                    foreach ($members as $key_3 => $record) {
                        $main_info[$record->unit . '_' . $record->practice_name]['members_not_ini'] = $record->members_count - ($main_info[$record->unit . '_' . $record->practice_name]['members_ini'] ?? 0);
                        unset($members[$key_3]);
                    }

                    $programs[$period['start'] . '_' . $period['end']] = $main_info;
                }

                foreach ($programs as $period => $record) {
                    foreach ($record as $program) {

                        $bhukti = District::find($program['bhukti_id']);

                        $regions[$program['region']][$program['bhukti']]['acarya'] = $bhukti->curator_acarya ? $bhukti->curator_acarya->profile->display_name : '';
                        $regions[$program['region']][$program['bhukti']]['bp'] = $bhukti->bp() ? $bhukti->bp()->profile->display_name : '';

                        $unit = Unit::where('name', $program['unit'])->first();

                        $regions[$program['region']][$program['bhukti']]['units'][$program['unit']]['active_members']['left'] = $unit->active_members_custom(request('left_start'), request('left_end'));
                        $regions[$program['region']][$program['bhukti']]['units'][$program['unit']]['active_members']['right'] = $unit->active_members_custom(request('right_start'), request('right_end'));

                        $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['ini']['users'] = $program['members_ini'] ?? 0;
                        $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['ini']['guests'] = $program['members_not_ini'];
                        $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['not_ini']['users'] = (integer)$program['guests_ini'];
                        $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['not_ini']['guests'] = (integer)$program['guests_not_ini'];
                    }
                }
            }
            else {

            }
        } else if($user->hasRole('secretary')) {
            $unit_id = $user->unit->id;

            $programs=[];

            foreach($periods as $key => $period) {

                $main_info = json_decode(json_encode(\DB::select("
            SELECT
reg.name as region,
dis.name AS bhukti,
dis.id AS bhukti_id,
u.name AS unit,
p.slug AS practice_name,
SUM(up_ini.initiated_guests) AS guests_ini,
SUM(up_ini.not_initiated_guests) AS guests_not_ini

FROM districts dis

LEFT JOIN dioceses dio ON dis.diocese_id = dio.id
LEFT JOIN regions reg ON dio.region_id = reg.id

LEFT JOIN district_areas di ON dis.id = di.district_id
LEFT JOIN units u ON di.id = u.district_area_id

LEFT JOIN units_programs up_ini ON up_ini.unit_id = u.id

LEFT JOIN programs p ON up_ini.program_id = p.id

WHERE up_ini.date >= ?
AND up_ini.date <= ?
AND u.id = ?

GROUP BY region, bhukti, unit, practice_name", [$period['start'], $period['end'], $unit_id])), true);

                foreach ($main_info as $key_1 => $record) {
                    $main_info[$record['unit'] . '_' . $record['practice_name']] = $record;
                    unset($main_info[$key_1]);
                }

                $members_ini = \DB::select("
            SELECT
u.name AS unit,
p.slug AS practice_name,

COUNT(uup_ini.id) AS ini_members_count

FROM units u

LEFT JOIN district_areas da ON u.district_area_id = da.id
LEFT JOIN districts dis ON da.district_id = dis.id

LEFT JOIN units_programs up_ini ON up_ini.unit_id = u.id
LEFT JOIN users_units_programs uup_ini ON up_ini.id = uup_ini.unit_program_id
LEFT JOIN meditation_lessons ml1 ON uup_ini.user_id = ml1.user_id

LEFT JOIN programs p ON up_ini.program_id = p.id

WHERE up_ini.date >= ?
AND up_ini.date <= ?
AND ml1.lesson_number = 1
AND u.id = ?

GROUP BY unit, practice_name", [$period['start'], $period['end'], $unit_id]);

                foreach ($members_ini as $key_2 => $record) {
                    $main_info[$record->unit . '_' . $record->practice_name]['members_ini'] = $record->ini_members_count;
                    unset($members_ini[$key_2]);
                }

                $members = \DB::select("
            SELECT
u.name AS unit,
p.slug AS practice_name,

COUNT(uup.id) AS members_count

FROM units u

LEFT JOIN district_areas da ON u.district_area_id = da.id
LEFT JOIN districts dis ON da.district_id = dis.id

LEFT JOIN units_programs up ON up.unit_id = u.id
LEFT JOIN users_units_programs uup ON up.id = uup.unit_program_id

LEFT JOIN programs p ON up.program_id = p.id

WHERE up.date >= ?
AND up.date <= ?
AND u.id = ?

GROUP BY unit, practice_name", [$period['start'], $period['end'], $unit_id]);

                foreach ($members as $key_3 => $record) {
                    $main_info[$record->unit . '_' . $record->practice_name]['members_not_ini'] = $record->members_count - ($main_info[$record->unit . '_' . $record->practice_name]['members_ini'] ?? 0);
                    unset($members[$key_3]);
                }

                $programs[$period['start'] . '_' . $period['end']] = $main_info;
            }

            foreach($programs as $period => $record) {
                foreach($record as $program) {

                    $bhukti = District::find($program['bhukti_id']);

                    $regions[$program['region']][$program['bhukti']]['acarya'] = $bhukti->curator_acarya ? $bhukti->curator_acarya->profile->display_name : '';
                    $regions[$program['region']][$program['bhukti']]['bp'] = $bhukti->bp() ? $bhukti->bp()->profile->display_name : '';

                    $unit = Unit::where('name', $program['unit'])->first();

                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']]['active_members']['left'] = $unit->active_members_custom(request('left_start'), request('left_end'));
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']]['active_members']['right'] = $unit->active_members_custom(request('right_start'), request('right_end'));

                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['ini']['users'] = $program['members_ini'] ?? 0;
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['ini']['guests'] = $program['members_not_ini'];
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['not_ini']['users'] = (integer)$program['guests_ini'];
                    $regions[$program['region']][$program['bhukti']]['units'][$program['unit']][$program['practice_name']][$period]['not_ini']['guests'] = (integer)$program['guests_not_ini'];
                }
            }
        } else {
            return [
                'status' => 'gerrarahere, man, im saying'
            ];
        }

        //dd(\DB::getQueryLog());

        return [
            'status' => 'ok',
            'regions' => $regions,
            'events' => $events
        ];
    }
}
