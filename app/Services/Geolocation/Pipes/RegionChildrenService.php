<?php

namespace App\Services\Geolocation\Pipes;

use App\Contracts\Geolocation\ChildrenInterface;
use App\Contracts\Geolocation\RegionRepositoryInterface;
use Closure;

class RegionChildrenService implements ChildrenInterface
{
    /**
     * @var RegionRepositoryInterface
     */
    private $regionRepository;

    /**
     * RegionChildrenService constructor.
     * @param RegionRepositoryInterface $regionRepository
     */
    public function __construct(RegionRepositoryInterface $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * @param array $children
     * @param Closure $next
     * @return array|mixed
     */
    public function handle(array $children, Closure $next)
    {
        if (empty($children['region'])) {
            return $next($children);
        }

        foreach ($this->regionRepository->getAllChildren($children['region']) as $dioceseId) {
            if (!empty($children['diocese']) && in_array($dioceseId, $children['diocese'], true)) {
                continue;
            }

            $children['diocese'][] = $dioceseId;
        }

        return $next($children);
    }
}
