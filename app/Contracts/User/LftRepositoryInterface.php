<?php

namespace App\Contracts\User;

interface LftRepositoryInterface
{
    public function save(array $data): bool;

    public function update(int $userId, array $data): bool;
}
