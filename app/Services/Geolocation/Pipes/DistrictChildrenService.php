<?php

namespace App\Services\Geolocation\Pipes;

use App\Contracts\Geolocation\ChildrenInterface;
use App\Contracts\Geolocation\DistrictRepositoryInterface;
use Closure;

class DistrictChildrenService implements ChildrenInterface
{
    /**
     * @var DistrictRepositoryInterface
     */
    private $districtRepository;

    /**
     * DioceseChildrenService constructor.
     * @param DistrictRepositoryInterface $districtRepository
     */
    public function __construct(DistrictRepositoryInterface $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    /**
     * @param array $children
     * @param Closure $next
     * @return array|mixed
     */
    public function handle(array $children, Closure $next)
    {
        if (empty($children['district'])) {
            return $children;
        }

        foreach ($this->districtRepository->getAllChildren($children['district']) as $districtAreaId) {
            if (!empty($children['district_area']) && in_array($districtAreaId, $children['district_area'], true)) {
                continue;
            }

            $children['district_area'][] = $districtAreaId;
        }

        return $children;
    }
}
