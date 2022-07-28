<?php

namespace App\Services\Geolocation\Pipes;

use App\Contracts\Geolocation\ChildrenInterface;
use App\Contracts\Geolocation\SectorRepositoryInterface;
use Closure;

class SectorChildrenService implements ChildrenInterface
{
    /**
     * @var SectorRepositoryInterface
     */
    private $sectorRepository;

    /**
     * SectorsChildrenService constructor.
     * @param SectorRepositoryInterface $sectorRepository
     */
    public function __construct(SectorRepositoryInterface $sectorRepository)
    {
        $this->sectorRepository = $sectorRepository;
    }

    /**
     * @param array $children
     * @param Closure $next
     * @return array|mixed
     */
    public function handle(array $children, Closure $next)
    {
        if (empty($children['sector'])) {
            return $next($children);
        }

        foreach ($this->sectorRepository->getAllChildren($children['sector']) as $regionId) {
            if (!empty($children['region']) && in_array($regionId, $children['region'], true)) {
                continue;
            }

            $children['region'][] = $regionId;
        }

        return $next($children);
    }
}
