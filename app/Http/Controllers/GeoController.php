<?php

namespace App\Http\Controllers;

use App\Http\Resources\GeoUnitsResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Models\Geolocation\District;
use App\Models\Geolocation\Sector;
use App\Models\Geolocation\Unit;
use App\Models\User\UserProfile;
use App\Repositories\Geolocation\DistrictRepository;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\User\User;

class GeoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::with(['users' => function($query) {
            $query->select('users.id', 'name', 'district_area_id');
        }, 'users.profile' => function($query) {
            $query->select('user_profiles.user_id', 'image', 'first_name', 'last_name', 'sex', 'spiritual_name');
        }])->get();

        $structure = [];
        $users_count = User::where('hidden', 0)->where('registration_completed', 1)->count();
        $users_without_city_count = UserProfile::leftJoin('users', 'users.id', '=', 'user_profiles.user_id')
            ->where('users.hidden', 0)
            ->where('users.registration_completed', 1)
            ->where('user_profiles.place_id', null)
            ->count();
        $users_without_area_count = User::where('hidden', 0)
            ->where('registration_completed', 1)
            ->where('district_area_id', null)
            ->count();

        $sectors = Sector::with('regions.dioceses.districts.districtAreas')->get();

        foreach ($sectors as $sector) {

            $sectorItem = [
                'id' => $sector->id,
                'name' => $sector->name,
                'regions' => [],
                'regionCount' => 0,
                'dioceseCount' => 0,
                'districtCount' => 0,
                'areaCount' => 0,
                'unitCount' => 0,
                'acaryas' => $sector->acaryas,
                'users' => 0
            ];

            foreach ($sector->regions as $region) {

                $regionItem = [
                    'id' => $region->id,
                    'name' => $region->name,
                    'dioceses' => [],
                    'dioceseCount' => 0,
                    'districtCount' => 0,
                    'areaCount' => 0,
                    'unitCount' => 0,
                    'acaryas' => $sectorItem['acaryas']->merge($region->acaryas),
                    'users' => 0
                ];

                foreach ($region->dioceses as $diocese) {

                    $dioceseItem = [
                        'id' => $diocese->id,
                        'name' => $diocese->name,
                        'districts' => [],
                        'districtCount' => 0,
                        'areaCount' => 0,
                        'unitCount' => 0,
                        'acaryas' => $regionItem['acaryas']->merge($diocese->acaryas),
                        'users' => 0
                    ];

                    foreach ($diocese->districts as $district) {

                        $districtItem = [
                            'id' => $district->id,
                            'name' => $district->name,
                            'areas' => [],
                            'areaCount' => 0,
                            'unitCount' => 0,
                            'roles' => [],
                            'acaryas' => $dioceseItem['acaryas']->merge($district->acaryas),
                            'users' => 0
                        ];

                        foreach ($district->districtAreas as $area) {

                            $areaItem = [
                                'id' => $area->id,
                                'name' => $area->name,
                                'units' => [],
                                'unitCount' => 0,
                                'roles' => [],
                                'acaryas' => $districtItem['acaryas']->merge($area->acaryas),
                                'users' => 0
                            ];

                            foreach ($area->units as $unit) {
                                $unitItem = [
                                    'id' => $unit->id,
                                    'name' => $unit->name,
                                    'roles' => [],
                                    'acaryas' => $areaItem['acaryas']->merge($unit->acaryas),
                                    'users' => 0
                                ];

                                foreach ($roles as $role) {

                                    $count = $area->users()->whereHas('roles', function ($query) use ($role) {
                                        $query->where('hidden', 0);
                                        $query->where('slug', $role->slug);
                                    })->count();

                                    $areaItem['roles'][$role->name] = $count;

                                    $districtItem['roles'][$role->name] = (($districtItem['roles'][$role->name] ?? 0) + $count);
                                    $dioceseItem['roles'][$role->name] = (($dioceseItem['roles'][$role->name] ?? 0) + $count);
                                    $regionItem['roles'][$role->name] = (($regionItem['roles'][$role->name] ?? 0) + $count);
                                    $sectorItem['roles'][$role->name] = (($sectorItem['roles'][$role->name] ?? 0) + $count);
                                }

                                $unitItem['users'] = $unit->users()->where('hidden', 0)->count();
                                $areaItem['units'][] = $unitItem;
                            }

                            $districtItem['unitCount'] += $areaItem['unitCount'] = count($areaItem['units']);

                            $districtItem['users'] += $areaItem['users'] = $area->users()->where('hidden', 0)->count();
                            $districtItem['areas'][] = $areaItem;

                        }

                        $dioceseItem['unitCount'] += $districtItem['unitCount'];
                        $dioceseItem['areaCount'] += $districtItem['areaCount'] = count($districtItem['areas']);

                        $dioceseItem['users'] += $districtItem['users'];
                        $dioceseItem['districts'][] = $districtItem;
                    }
                    $regionItem['unitCount'] += $dioceseItem['unitCount'];
                    $regionItem['areaCount'] += $dioceseItem['areaCount'];
                    $regionItem['districtCount'] += $dioceseItem['districtCount'] = count($dioceseItem['districts']);

                    $regionItem['users'] += $dioceseItem['users'];
                    $regionItem['dioceses'][] = $dioceseItem;
                }
                $sectorItem['unitCount'] += $regionItem['unitCount'];
                $sectorItem['areaCount'] += $regionItem['areaCount'];
                $sectorItem['districtCount'] += $regionItem['districtCount'];
                $sectorItem['dioceseCount'] += $regionItem['dioceseCount'] = count($regionItem['dioceses']);

                $sectorItem['users'] += $regionItem['users'];
                $sectorItem['regions'][] = $regionItem;
            }

            $sectorItem['regionCount'] = count($sectorItem['regions']);
            $structure[] = $sectorItem;
        }

        $data = [
            'structure' => $structure,
            'users_count' => $users_count,
            'users_without_city_count' => $users_without_city_count,
            'users_without_area_count' => $users_without_area_count
        ];

        return view('geo.report', compact('data'));
    }

    public function getUnits(DistrictRepository $districtRepository) {
        if(auth()->user()->hasRole(['admin', 'geo-editor', 'bc', 'geo'])) {
            $bhuktis = District::whereHas('districtAreas', function ($q) {
                $q->whereHas('units');
            })->get();;
        } else {
            $bhuktis = auth()->user()->bpDistricts;

            //$units = GeoUnitsResource::collection($districtRepository->getAllUnitsOfBP(auth()->user()->id));
        }

        $units = [];
        $acaryas = [];

        foreach($bhuktis as $bhukti) {
            $bhuktis = GeoUnitsResource::collection($bhukti->units);

            $units[$bhukti->name] = $bhuktis;
            $acaryas[$bhukti->name] = optional($bhukti->curator_acarya)->displayName;
        }

        $total_users = User::whereHas('profile')->where('hidden', false)->where(function ($q) {
            $q->where('registration_completed', true)
                ->orWhere('fake', true);
        })->count();

        return [
            'units' => $units,
            'total_users' => $total_users,
            'acaryas' => $acaryas
        ];
    }
}
