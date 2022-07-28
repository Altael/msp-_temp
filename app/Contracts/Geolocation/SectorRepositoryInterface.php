<?php

namespace App\Contracts\Geolocation;

use Illuminate\Support\Collection;

interface SectorRepositoryInterface
{
    public function getAll(): Collection;

    public function getAllWithAcaryas(): Collection;

    public function store(string $name, array $acaryas, ?string $notes): bool;

    public function update(int $id, string $name, array $acaryas, ?string $notes): int;

    public function delete(int $id): int;

    public function getAllChildren(array $ids): array;
}
