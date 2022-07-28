<?php

namespace App\Contracts\Geolocation;

use Illuminate\Support\Collection;

interface DioceseRepositoryInterface
{
    public function getAll(): Collection;

    public function store(int $regionId, string $name, array $acaryas, ?string $notes): bool;
    public function update(int $dioceseId, string $name, array $acaryas, ?string $notes): int;

    public function delete(int $id): int;
}
