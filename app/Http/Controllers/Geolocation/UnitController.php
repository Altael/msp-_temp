<?php

namespace App\Http\Controllers\Geolocation;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeoEditResource;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\UnitEditResource;
use App\Http\Resources\UnitMembersResource;
use App\Http\Resources\UnitTitlesResource;
use App\Http\Resources\UnitUserResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Http\Resources\UsersStatusesResource;
use App\Models\Geolocation\DistrictArea;
use App\Models\Geolocation\Unit;
use App\Models\User\User;
use App\Repositories\Geolocation\UnitRepository;
use App\Repositories\User\UserRepository;
use App\Status;
use App\UnitTitle;
use jeremykenedy\LaravelRoles\Models\Role;

class UnitController extends Controller
{
    public function index(UnitRepository $repository, UserRepository $userRepository)
    {
        $area = DistrictArea::findOrFail(request('districtAreaId'));
        $areaUsers = $area->users()->where('hidden', 0)->whereDoesntHave('units')->orderBy('name')->get();

        $units = UnitEditResource::collection($repository->getAll())->additional([
            'meta' => [
                'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0)),
                'areaUsers' => UnitUserResource::collection($areaUsers)
            ]
        ]);

        return $units;
    }

    public function show(Unit $unit)
    {
        return $unit;
    }

    public function store(UnitRepository $repository)
    {
        $this->validate(request(), [
            'districtAreaId' => 'required|integer',
            'name' => 'required|max:255'
        ]);

        $unit = $repository->store(
                request('districtAreaId'),
                request('name'),
                request('acaryas', []),
                request('users', []),
                request('registration_status'),
                request('notes', ''),
                request('secretaryId')
            );

        if(!$unit) {
            return [
                'status' => $unit
            ];
        }

        $districtArea = $unit->districtArea()->first();

        if(!$districtArea->default_unit_id) {
            $districtArea->update(['default_unit_id' => $unit->id]);
        }

        \Artisan::call('users:unit-placement');

        return [
            'status' => new UnitEditResource($unit)
        ];
    }

    public function update(UnitRepository $repository, $unitId)
    {
        $this->validate(request(), [
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->update(
                $unitId,
                request('name'),
                request('acaryas', []),
                request('users', []),
                request('registration_status'),
                request('notes'),
                request('secretaryId')
            )
        ];
    }

    public function destroy(UnitRepository $repository, $unitId)
    {
        return [
            'status' => $repository->delete($unitId)
        ];
    }

    public function info()
    {
        $user = User::findOrFail(auth()->user()->id);
        $unit = $user->units()->first();

        $secretary_role_id = Role::where('slug', 'secretary')->first()->id;

        $secretaries = UnitMembersResource::collection($unit->users()->whereHas('roles', function ($q) use ($secretary_role_id) {
            $q->where('role_id', $secretary_role_id);
        })->get());

        $members = $unit->users()->withCount('events')
            ->orderBy('events_count', 'desc');

        $unfiltered = $members->count();

        $members->whereDoesntHave('roles', function ($q) use ($secretary_role_id) {
            $q->where('role_id', $secretary_role_id);
        });

        if($statuses = request('statuses')) {
            $members->whereHas('statuses', function ($query) use ($statuses) {
                $query->whereIn('status_id', $statuses);
            });
        }

        if(!$user->hasSuperRole()) {
            $unit_status_id = Status::where('name_en', 'Unit')->first()->id;

            $members->where('fake', false);

            $members->whereHas('statuses', function ($query) use ($unit_status_id){
                $query->where('status_id', $unit_status_id);
            })->whereHas('profile', function ($q) use ($user) {
                $q->where('hide_from_unit', false);
            })->orWhere('users.id', $user->id);
        }

        $members = UnitMembersResource::collection($members->get());

        return [
            'unit' => $unit,
            'members' => $members,
            'secretaries' => $secretaries,
            'lang' => $user->language,
            'total' => $members->count() + $secretaries->count(),
            'unfiltered' => $unfiltered
        ];
    }

    public function getTitles() {
        return [
            'titles' => UnitTitlesResource::collection(UnitTitle::all())
        ];
    }
}
