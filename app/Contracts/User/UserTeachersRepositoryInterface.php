<?php

namespace App\Contracts\User;

interface UserTeachersRepositoryInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool;

    /**
     * @param int $userId
     * @return int
     */
    public function getTeacherIdByUserId(int $userId): int;
}
