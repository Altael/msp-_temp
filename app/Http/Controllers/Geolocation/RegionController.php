<?php

namespace App\Http\Controllers\Geolocation;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeoEditResource;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Models\Geolocation\Region;
use App\Repositories\Geolocation\RegionRepository;
use App\Repositories\User\UserRepository;

class RegionController extends Controller
{
    public function index(RegionRepository $repository, UserRepository $userRepository)
    {
        $regions = GeoEditResource::collection($repository->getAll())->additional([
            'meta' => [
                'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0))
            ]
        ]);

        return $regions;
    }

    public function show(Region $region)
    {
        return $region->load('dioceses');
    }

    public function store(RegionRepository $repository)
    {
        $this->validate(request(), [
            'sectorId' => 'required|integer',
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->store(
                request('sectorId'),
                request('name'),
                request('acaryas', []),
                request('notes', '')
            )
        ];
    }

    public function update(RegionRepository $repository, $regionId)
    {
        $this->validate(request(), [
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->update(
                $regionId,
                request('name'),
                request('acaryas', []),
                request('notes')
            )
        ];
    }

    public function destroy(RegionRepository $repository, $regionId)
    {
        return [
            'status' => $repository->delete($regionId)
        ];
    }
}
