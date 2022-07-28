<?php

namespace App\Repositories\User;

use App\Contracts\User\LftRepositoryInterface;
use App\Models\User\Lft;

class LftRepository implements LftRepositoryInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        return (bool)Lft::create($data);
    }

    /**
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function update(int $userId, array $data): bool
    {
        return (bool)Lft::where('user_id', $userId)
            ->update($data);
    }
}
