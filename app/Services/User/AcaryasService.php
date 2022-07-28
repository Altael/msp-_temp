<?php

namespace App\Services\User;

use App\Contracts\User\UserProfileRepositoryInterface;
use App\Services\Geolocation\AcaryaGeoService;

class AcaryasService
{
    /**
     * @var AcaryaGeoService
     */
    private $acaryaGeoService;

    /**
     * @var UserProfileRepositoryInterface
     */
    private $userProfileRepository;

    /**
     * AcaryasService constructor.
     * @param AcaryaGeoService $acaryaGeoService
     * @param UserProfileRepositoryInterface $userProfileRepository
     */
    public function __construct(
        AcaryaGeoService $acaryaGeoService,
        UserProfileRepositoryInterface $userProfileRepository
    ) {
        $this->acaryaGeoService = $acaryaGeoService;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getAcaryasByGeoRegions(int $userId): array
    {
        $geoRegions = $this->acaryaGeoService->getAcaryaFullPermissions($userId);
        if (empty($geoRegions)) {
            return [];
        }

        return $this->userProfileRepository->getAcaryasByGeoRegions($userId, $geoRegions);
    }
}
