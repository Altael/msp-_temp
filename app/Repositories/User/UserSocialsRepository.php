<?php

namespace App\Repositories\User;

use App\Contracts\User\UserSocialsRepositoryInterface;
use App\Models\User\UserSocials;

class UserSocialsRepository implements UserSocialsRepositoryInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        return (bool)UserSocials::create($data);
    }

    /**
     * @param string $socialId
     * @param string $provider
     * @return int
     */
    public function findUserIdBySocialIdByProvider(string $socialId, string $provider): int
    {
        return (int)UserSocials::where('social_id', $socialId)
            ->where('provider', $provider)
            ->value('user_id');
    }
}
