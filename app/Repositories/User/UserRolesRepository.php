<?php

namespace App\Repositories\User;

use App\Contracts\User\UserRolesRepositoryInterface;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Models\Role;

class UserRolesRepository implements UserRolesRepositoryInterface
{
    /**
     * @param int $userId
     * @return array
     */
    public function getRolesByUserId(int $userId): array
    {
        return DB::table('role_user as ru')
            ->join('roles as r', 'r.id', '=', 'ru.role_id')
            ->where('user_id', $userId)
            ->select(
                'r.name as name',
                'r.slug as slug'
            )
            ->get()
            ->toArray();
    }
}
