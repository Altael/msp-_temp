<?php

namespace App\Services\Geolocation;

use App\Models\Geolocation\Diocese;
use App\Repositories\Geolocation\DioceseRepository;

class DioceseService
{
    private $repository;

    public function __construct(DioceseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(int $regionId, string $name): bool
    {
        return $this->repository->store($regionId, $name);
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }
}
