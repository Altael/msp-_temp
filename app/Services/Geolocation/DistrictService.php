<?php

namespace App\Services\Geolocation;

use App\Contracts\Geolocation\DistrictRepositoryInterface;

class DistrictService
{
    /**
     * @var DistrictRepositoryInterface
     */
    private $repository;

    /**
     * DistrictService constructor.
     * @param DistrictRepositoryInterface $repository
     */
    public function __construct(DistrictRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $dioceseId
     * @param string $name
     * @return bool
     */
    public function store(int $dioceseId, string $name): bool
    {
        return $this->repository->store($dioceseId, $name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }
}
