<?php

namespace App\Services\Geolocation;

use App\Contracts\Geolocation\DistrictAreaRepositoryInterface;
use App\Contracts\Geolocation\DistrictAreaTasksRepositoryInterface;

class DistrictAreaService
{
    /**
     * @var DistrictAreaRepositoryInterface
     */
    private $repository;

    /**
     * @var UserPlacesService
     */
    private $userPlacesService;

    /**
     * @var DistrictAreaTasksRepositoryInterface
     */
    private $districtAreaTasksRepository;

    /**
     * DistrictAreaService constructor.
     * @param DistrictAreaRepositoryInterface $repository
     * @param UserPlacesService $userPlacesService
     * @param DistrictAreaTasksRepositoryInterface $districtAreaTasksRepository
     */
    public function __construct(
        DistrictAreaRepositoryInterface $repository,
        UserPlacesService $userPlacesService,
        DistrictAreaTasksRepositoryInterface $districtAreaTasksRepository
    ) {
        $this->repository = $repository;
        $this->userPlacesService = $userPlacesService;
        $this->districtAreaTasksRepository = $districtAreaTasksRepository;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        $params = [
            'district_id' => $data['districtId'],
            'name' => $data['name'],
            'place_id' => $data['placeId'],
            'type' => $data['type'],
            'default_unit_id' => $data['default_unit_id'] ? $data['default_unit_id']['id'] : null
        ];

        $acaryas = $data['acaryas'] ?? [];
        $id = $this->repository->store($params, $acaryas);

        if (empty($id)) {
            return false;
        }

        return true;
    }

    /**
     * @param int $districtId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $districtId)
    {
        return $this->repository->getAll($districtId);
    }

    /**
     * @param string $placeId
     * @param array $districtArea
     * @return int
     * @throws \Exception
     */
    public function findByPlaceId(string $placeId, array $districtArea = []): int
    {
        $filter = [
            'locality' => 'city',
            'administrative_area_level_1' => 'region',
            'administrative_area_level_2' => 'region',
            'country' => 'country'
        ];

        $details = $this->userPlacesService->getDetailsByPlaceId($placeId);

        if (empty($details)) {
            return 0;
        }

        foreach ($details['address_components'] as $component) {
            $type = array_shift($component['types']);

            if (!($filter[$type] ?? null)) {
                continue;
            }

            $place = $this->userPlacesService->getPlaceByName($component['long_name']);

            foreach ($place['predictions'] as $prediction) {
                if (!empty($districtArea)) {
                    if ($prediction['place_id'] === $districtArea['placeId'] && $type === $districtArea['type']) {
                        return $districtArea['id'];
                    }

                    continue;
                }

                $districtAreaId = $this->repository->getByPlaceIdByType($prediction['place_id'], $type);

                if ($districtAreaId) {
                    return $districtAreaId;
                }
            }
        }

        return 0;
    }
}
