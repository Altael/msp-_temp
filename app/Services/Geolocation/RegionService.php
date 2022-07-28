<?php

namespace App\Services\Geolocation;

use App\Contracts\RegionRepositoryInterface;

class RegionService
{
    /**
     * @var RegionRepositoryInterface
     */
    private $regionRepository;

    /**
     * RegionService constructor.
     * @param RegionRepositoryInterface $regionRepository
     */
    public function __construct(RegionRepositoryInterface $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function save(string $name): bool
    {
        return $this->regionRepository->save($name);
    }

    public function getAll()
    {
        // some business logic
    }
}
