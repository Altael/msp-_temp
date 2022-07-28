<?php

namespace App\Contracts\Geolocation;

interface DistrictAreaTasksRepositoryInterface
{
    public function save(array $data): bool;

    public function getAll(): array;

    public function deleteByIds(array $ids): int;
}
