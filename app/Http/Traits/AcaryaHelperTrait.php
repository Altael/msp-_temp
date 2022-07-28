<?php

namespace App\Http\Traits;

use App\Contracts\User\UserProfileRepositoryInterface;

trait AcaryaHelperTrait
{
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return session('user.acaryaId') ?? auth()->user()->id;
    }

    public function getUserName()
    {
        if (!session('user.acaryaId')) {
            return auth()->user()->display_name;
        }

        return app(UserProfileRepositoryInterface::class)->findByUserId(session('user.acaryaId'))->getDisplayNameAttribute();
    }
}
