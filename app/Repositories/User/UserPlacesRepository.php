<?php

namespace App\Repositories\User;

use App\Contracts\User\UserPlacesRepositoryInterface;
use App\Models\User\UserPlaces;

class UserPlacesRepository implements UserPlacesRepositoryInterface
{
    /**
     * @param array $data
     * @return UserPlaces
     */
    public function save(array $data): UserPlaces
    {
        return UserPlaces::create($data);
    }

    /**
     * @param string $id
     * @return array
     */
    public function getById(string $id): array
    {
        return UserPlaces
                ::where('id', $id)
                ->get()
                ->toArray() ?? [];
    }
}
