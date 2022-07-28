<?php

namespace App\Contracts\User;

use App\Models\User\UserProfile;

interface UserProfileRepositoryInterface
{
    /**
     * @param array $data
     * @return UserProfile
     */
    public function save(array $data): UserProfile;

    /**
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function update(int $userId, array $data): bool;

    /**
     * @param int $userId
     * @return UserProfile|null
     */
    public function findByUserId(int $userId): ?UserProfile;

    /**
     * @param int $userId
     * @param array $geoRegions
     * @return array
     */
    public function getAcaryasByGeoRegions(int $userId, array $geoRegions): array;
}
