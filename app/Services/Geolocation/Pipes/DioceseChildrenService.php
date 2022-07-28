<?php

namespace App\Services\Geolocation\Pipes;

use App\Contracts\Geolocation\ChildrenInterface;
use App\Contracts\Geolocation\DioceseRepositoryInterface;
use Closure;

class DioceseChildrenService implements ChildrenInterface
{
    /**
     * @var DioceseRepositoryInterface
     */
    private $dioceseRepository;

    /**
     * DioceseChildrenService constructor.
     * @param DioceseRepositoryInterface $dioceseRepository
     */
    public function __construct(DioceseRepositoryInterface $dioceseRepository)
    {
        $this->dioceseRepository = $dioceseRepository;
    }

    /**
     * @param array $children
     * @param Closure $next
     * @return array|mixed
     */
    public function handle(array $children, Closure $next)
    {
        if (empty($children['diocese'])) {
            return $next($children);
        }

        foreach ($this->dioceseRepository->getAllChildren($children['diocese']) as $districtId) {
            if (!empty($children['district']) && in_array($districtId, $children['district'], true)) {
                continue;
            }

            $children['district'][] = $districtId;
        }

        return $next($children);
    }
}
