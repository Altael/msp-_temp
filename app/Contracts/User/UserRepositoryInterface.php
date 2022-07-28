<?php

namespace App\Contracts\User;

use App\Models\User\User;

interface UserRepositoryInterface
{
    public function findUsersByDistrictAreaTypes(array $type = []): array;

    public function save(array $data): User;

    public function update(int $userId, array $data): bool;

    public function findIdByEmail(string $email): int;
}
