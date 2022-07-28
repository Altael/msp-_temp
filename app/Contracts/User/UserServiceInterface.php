<?php

namespace App\Contracts\User;

use App\Models\User\User;

interface UserServiceInterface
{
    public function save(array $data): User;
}
