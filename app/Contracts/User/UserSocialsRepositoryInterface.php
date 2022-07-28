<?php

namespace App\Contracts\User;

interface UserSocialsRepositoryInterface
{
    public function save(array $data): bool;

    public function findUserIdBySocialIdByProvider(string $socialId, string $provider): int;
}
