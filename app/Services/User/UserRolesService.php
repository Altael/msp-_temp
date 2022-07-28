<?php

namespace App\Services\User;

use App\Contracts\User\AcaryaHelperRepositoryInterface;
use App\Contracts\User\UserRolesRepositoryInterface;
use App\Models\User\User;

class UserRolesService
{
    /**
     * @var AcaryaHelperRepositoryInterface
     */
    private $acaryaHelperRepository;

    /**
     * @var UserRolesRepositoryInterface
     */
    private $userRolesRepository;

    public function __construct(
        AcaryaHelperRepositoryInterface $acaryaHelperRepository,
        UserRolesRepositoryInterface $userRolesRepository
    )
    {
        $this->acaryaHelperRepository = $acaryaHelperRepository;
        $this->userRolesRepository = $userRolesRepository;
    }

    /**
     * @param User $user
     * @param string $role
     */
    public function attachRole(User $user, string $role): void
    {
        $role = config('roles.models.role')::where('name', '=', $role)->first();
        $user->attachRole($role);
    }

    /**
     * @param int $userId
     */
    public function setDefaultHelperAcarya(int $userId): void
    {
        if(auth()->user() && auth()->user()->hasRole('helper')){
            $acaryas = $this->acaryaHelperRepository->getAcaryasByHelperId($userId);
            if (empty($acaryas)) {
                return;
            }
            session()->put('user.acaryas', $acaryas);
            $this->setHelperAcarya($acaryas[0]['id']);
        }
    }

    /**
     * @param int $acaryaId
     * @return bool
     */
    public function changeHelperAcarya(int $acaryaId): bool
    {
        $acaryas = session('user.acaryas');

        if (empty($acaryas)) {
            return false;
        }

        $acaryasIds = array_pluck($acaryas, 'id');
        if (empty($acaryasIds)) {
            return false;
        }

        if (!in_array($acaryaId, $acaryasIds, true)) {
            return false;
        }

        $this->setHelperAcarya($acaryaId);

        return true;
    }

    /**
     * @param int $acaryaId
     */
    private function setHelperAcarya(int $acaryaId): void
    {
        session()->put('user.acaryaId', $acaryaId);
        session()->save();
    }

    /**
     * @param int $userId
     * @return array
     */
    private function getUserRoles(int $userId): array
    {
        $result = $this->userRolesRepository->getRolesByUserId($userId);
        return $result;
    }
}
