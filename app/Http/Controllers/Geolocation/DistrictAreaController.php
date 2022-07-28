<?php

namespace App\Http\Controllers\Geolocation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Geolocation\DistrictAreaRequest;
use App\Http\Resources\DistrictAreaEditResource;
use App\Http\Resources\GeoEditResource;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\UnitEditResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Repositories\Geolocation\DistrictAreaRepository;
use App\Repositories\User\UserRepository;
use App\Services\Geolocation\DistrictAreaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DistrictAreaController extends Controller
{

    public function index(DistrictAreaRepository $repository, UserRepository $userRepository)
    {
        $areas = DistrictAreaEditResource::collection($repository->getAll())->additional([
            'meta' => [
                'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0))
            ]
        ]);

        return $areas;
    }

    public function store(
        DistrictAreaRequest $districtAreaRequest,
        DistrictAreaService $districtAreaService
    ): JsonResponse {
        return response()->json(['status' => $districtAreaService->store($districtAreaRequest->all())]);
    }

    public function update(DistrictAreaRepository $repository, $districtAreaId)
    {
        $this->validate(request(), [
            'name' => 'required|max:255'
        ]);

        return [
            'status' => $repository->update(
                $districtAreaId,
                request('name'),
                request('placeId'),
                request('type'),
                request('acaryas', []),
                request('default_unit_id')['id'] ?? null,
                request('notes', '')
            )
        ];
    }

    public function destroy(DistrictAreaRepository $repository, $districtAreaId)
    {
        return [
            'status' => $repository->delete($districtAreaId)
        ];
    }
}
