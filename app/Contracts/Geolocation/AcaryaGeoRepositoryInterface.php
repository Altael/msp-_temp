<?php

namespace App\Contracts\Geolocation;

interface AcaryaGeoRepositoryInterface
{
    public function getByAcaryaId(int $acaryaId): array;
}
