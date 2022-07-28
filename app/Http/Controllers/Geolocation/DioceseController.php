<?php

namespace App\Http\Controllers\Geolocation;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeoEditResource;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Models\Geolocation\Diocese;
use App\Repositories\Geolocation\DioceseRepository;
use App\Repositories\User\UserRepository;
use App\Services\Geolocation\DioceseService;

class DioceseController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(DioceseRepository $repository, UserRepository $userRepository)
    {
        $dioceses = GeoEditResource::collection($repository->getAll())->additional([
            'meta' => [
                'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0))
            ]
        ]);
        return $dioceses;
    }

    public function show(Diocese $diocese)
    {
        return $diocese->load('districts');
    }

    public function store(DioceseRepository $repository)
    {
        $this->validate(request(), [
            'regionId' => 'required|integer',
            'name' => 'required|max:255',
        ]);

        return [
            'status' => $repository->store(
                request('regionId'),
                request('name'),
                request('acaryas', []),
                request('notes', '')
            )
        ];
    }

    public function update(DioceseRepository $repository, $dioceseId)
    {
        return [
            'status' => $repository->update(
                $dioceseId,
                request('name'),
                request('acaryas', []),
                request('notes')
            )
        ];
    }

    public function destroy(DioceseRepository $repository, $dioceseId)
    {
        return [
            'status' => $repository->delete($dioceseId)
        ];
    }
}
