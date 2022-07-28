<?php

namespace App\Services\Geolocation;

use App\Contracts\Geolocation\AcaryaGeoRepositoryInterface;

class AcaryaGeoService
{
    private const GEO_PRIORITY = [
        GeolocationService::SECTOR => 6,
        GeolocationService::REGION => 5,
        GeolocationService::DIOCESE => 4,
        GeolocationService::DISTRICT => 3,
        GeolocationService::DISTRICT_AREA => 2,
        GeolocationService::UNIT => 1
    ];

    /**
     * @var AcaryaGeoRepositoryInterface
     */
    private $acaryaGeoRepository;

    /**
     * @var GeolocationService
     */
    private $geolocationService;

    /**
     * AcaryaGeoService constructor.
     * @param AcaryaGeoRepositoryInterface $acaryaGeoRepository
     * @param GeolocationService $geolocationService
     */
    public function __construct(
        AcaryaGeoRepositoryInterface $acaryaGeoRepository,
        GeolocationService $geolocationService
    ) {
        $this->acaryaGeoRepository = $acaryaGeoRepository;
        $this->geolocationService = $geolocationService;
    }

    /**
     * @param int $acaryaId
     * @return array
     */
    public function getAcaryaFullPermissions(int $acaryaId): array
    {
        return $this->geolocationService->getChildren($this->getGeoLocations($acaryaId));
    }

    /**
     * @param int $acaryaId
     * @return array
     */
    public function getGeoLocations(int $acaryaId): array
    {
        $acaryaGeos = $this->acaryaGeoRepository->getByAcaryaId($acaryaId);
        if (empty($acaryaGeos)) {
            return [];
        }

        return $this->sortByPriority($acaryaGeos);
    }

    /**
     * @param array $acaryaGeos
     * @return array
     */
    private function sortByPriority(array $acaryaGeos): array
    {
        usort($acaryaGeos, static function ($a, $b) {
            $priorityA = self::GEO_PRIORITY[$a['type']];
            $priorityB = self::GEO_PRIORITY[$b['type']];

            return $priorityA < $priorityB ? 1 : -1;
        });

        $result = [];
        foreach ($acaryaGeos as $acaryaGeo) {
            $result[$acaryaGeo['type']][] = $acaryaGeo['geo_id'];
        }

        return $result;
    }
}
