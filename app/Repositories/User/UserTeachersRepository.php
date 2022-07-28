<?php

namespace App\Repositories\User;

use App\Contracts\User\UserTeachersRepositoryInterface;
use App\Models\User\UserTeachers;

class UserTeachersRepository implements UserTeachersRepositoryInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        return (bool)UserTeachers::create($data);
    }

    /**
     * @param int $userId
     * @return int
     */
    public function getTeacherIdByUserId(int $userId): int
    {
        return (int)UserTeachers
            ::where('user_id', $userId)
            ->value('teacher_user_id');
    }
}
