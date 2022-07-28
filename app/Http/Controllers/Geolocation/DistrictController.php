<?php

namespace App\Http\Controllers\Geolocation;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictEditResource;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Models\Geolocation\District;
use App\Models\Geolocation\Unit;
use App\Models\User\User;
use App\Repositories\Geolocation\DistrictRepository;
use App\Repositories\User\UserRepository;
use App\Services\Geolocation\DistrictAreaService;

class DistrictController extends Controller
{
    public function index(DistrictRepository $repository, UserRepository $userRepository)
    {
        $districts = [];

        if(auth()->user()->hasRole('all_districts')) {
            $districts = DistrictEditResource::collection($repository->getAll())->additional([
                'meta' => [
                    'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0)),
                    'bps' => UserIdDisplayNameResource::collection($userRepository->getAllBPs()->where('hidden', 0))
                ]
            ]);
        } elseif (auth()->user()->hasRole('admin|geo|geo-edit|bc')) {
            $districts = DistrictEditResource::collection($repository->getAll())->additional([
                'meta' => [
                    'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0)),
                    'bps' => UserIdDisplayNameResource::collection($userRepository->getAllBPs()->where('hidden', 0))
                ]
            ]);
        } elseif (auth()->user()->hasRole('bp')) {
            $districts = DistrictEditResource::collection($repository->getAllOfBP());
        }

        return $districts;
    }

    public function full(DistrictRepository $repository, UserRepository $userRepository)
    {
        $districts = [];

        if (auth()->user()->hasRole('admin|geo|geo-edit|bc')) {
            $bhuktis = District::whereHas('bps');

            $units = Unit::whereHas('district', function ($q) {
                $q->whereHas('bps');
            });

            $districts = [
                'data' => $repository->getAllByCountries(),
                'meta' => [
                    'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0)),
                    'all_acaryas' => UserIdDisplayNameResource::collection(User::whereHas('roles', function ($q) {
                        $q->where('slug', 'acarya');
                    })->get()),
                    'bps' => UserIdDisplayNameResource::collection($userRepository->getAllBPs()->where('hidden', 0)),
                    'registered_bhuktis' => $bhuktis->count(),
                    'bhuktis' => District::all()->count(),
                    'units' => [
                        'all' => $units->count(),
                        'of_reg' => (clone $units)->where('registration_status', 'of_reg')->count(),
                        'not_reg' => (clone $units)->where('registration_status', 'not_reg')->count(),
                        'um' => (clone $units)->where('registration_status', 'um')->count()
                    ]
                ]
            ];

        } elseif (auth()->user()->hasRole('bp')) {
            $districts = DistrictEditResource::collection($repository->getAllOfBP());
        }

        return $districts;
    }

    public function bp_works()
    {
        $bps_s = request('bps');

        $bps = [];

        foreach($bps_s as $bp) {
            if($bp['id']) {
                $bps[$bp['id']] = ['rank' => $bp['rank']];
            }
        }

        $bhukti = District::findOrFail(request('bhukti_id'));

        $bhukti->bps()->sync($bps);

        return [
            'hehe' => 'boy'
        ];
    }

    public function acarya_works()
    {
        $acarya_id = request('id');

        $bhukti = District::findOrFail(request('bhukti_id'))->update([
            'curator_acarya_id' => $acarya_id
        ]);

        return [
            'hehe' => 'boy'
        ];
    }

    public function show(District $district)
    {
        return $district->load('districtAreas');
    }

    public function store(DistrictRepository $repository)
    {
        $this->validate(request(), [
            'dioceseId' => 'required|integer',
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->store(
                request('dioceseId'),
                request('name'),
                request('acaryas', []),
                request('notes', ''),
                request('country_id')
            )
        ];
    }

    public function update(DistrictRepository $repository, $districtId)
    {
        $this->validate(request(), [
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->update(
                $districtId,
                request('name'),
                request('acaryas', []),
                request('notes'),
                request('country_id')
            )
        ];
    }

    public function destroy(DistrictRepository $repository, $districtId)
    {
        return [
            'status' => $repository->delete($districtId)
        ];
    }

    public function match(DistrictAreaService $service)
    {
        $this->validate(request(), [
            'placeId' => 'required|max:255'
        ]);

        $districtAreaId = $service->findByPlaceId(request('placeId'));

        return [
            'status' => $districtAreaId ? 'found' : 'not found',
            'districtAreaId' => $districtAreaId
        ];
    }
}
