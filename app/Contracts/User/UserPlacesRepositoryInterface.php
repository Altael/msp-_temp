<?php

namespace App\Contracts\User;

use App\Models\User\UserPlaces;

interface UserPlacesRepositoryInterface
{
    /**
     * @param array $data
     * @return UserPlaces
     */
    public function save(array $data): UserPlaces;

    /**
     * @param string $id
     * @return array
     */
    public function getById(string $id): array;
}
