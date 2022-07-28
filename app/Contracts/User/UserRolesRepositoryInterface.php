<?php

namespace App\Contracts\User;

interface UserRolesRepositoryInterface
{
    public function getRolesByUserId(int $userId): array;
}
