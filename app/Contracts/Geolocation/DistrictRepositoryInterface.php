<?php

namespace App\Contracts\Geolocation;

interface DistrictRepositoryInterface
{

    public function store(int $dioceseId, string $name, array $acaryas, ?string $notes, $country_id): bool;

    public function update(int $id, string $name, array $acaryas, ?string $notes, $country_id): int;

    public function delete(int $id): int;

    public function getAllChildren(array $ids): array;
}
