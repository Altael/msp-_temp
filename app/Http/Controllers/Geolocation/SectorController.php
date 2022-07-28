<?php

namespace App\Http\Controllers\Geolocation;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Http\Resources\GeoEditResource;
use App\Models\Geolocation\Sector;
use App\Repositories\Geolocation\SectorRepository;
use App\Repositories\User\UserRepository;

class SectorController extends Controller
{
    public function index(SectorRepository $repository, UserRepository $userRepository)
    {
        $sectors = GeoEditResource::collection($repository->getAll())->additional([
            'meta' => [
                'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0))
            ]
        ]);

        return $sectors;
    }

    public function show(Sector $sector)
    {
        return $sector->load('dioceses');
    }

    public function store(SectorRepository $repository)
    {
        $this->validate(request(), [
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->store(
                request('name'),
                request('acaryas', []),
                request('notes')
                )
        ];
    }

    public function update(SectorRepository $repository, $sectorId)
    {
        $this->validate(request(), [
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->update(
                $sectorId,
                request('name'),
                request('acaryas', []),
                request('notes', '')
            )
        ];
    }

    public function destroy(SectorRepository $repository, $sectorId)
    {
        return [
            'status' => $repository->delete($sectorId)
        ];
    }
}
