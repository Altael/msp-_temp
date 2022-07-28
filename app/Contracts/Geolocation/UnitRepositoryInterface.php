<?php

namespace App\Contracts\Geolocation;

interface UnitRepositoryInterface
{

    public function store(int $districtAreaId, string $name, array $acaryas, array $users, string $registration_status, ?string $notes,  ?int $secretaryId);

    public function update(int $id, string $name, array $acaryas, array $users, string $registration_status, ?string $notes, ?int $secretaryId): int;

    public function delete(int $id): int;
}
