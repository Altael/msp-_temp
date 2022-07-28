<?php

namespace App\Contracts\Geolocation;

interface RegionServiceInterface
{
    public function save(string $name): bool;
}
