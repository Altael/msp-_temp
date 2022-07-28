<?php

namespace App\Contracts\Geolocation;

interface DistrictAreaRepositoryInterface
{
    public function store(array $params, array $acaryas): int;

    public function getAll();

    public function update(int $id, string $name, string $placeId, string $type, array $acaryas, ?int $unitId, ?string $notes): int;

    public function delete(int $id): int;

    public function getByPlaceIdByType(string $placeId, string $type): int;
}
