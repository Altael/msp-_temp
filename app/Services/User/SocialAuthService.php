<?php

namespace App\Services\User;

use App\Contracts\User\SocialAuthInterface;
use App\Contracts\User\UserProfileRepositoryInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserSocialsRepositoryInterface;
use Laravel\Socialite\Contracts\User;

class SocialAuthService implements SocialAuthInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserSocialsRepositoryInterface
     */
    private $userSocialsRepository;

    /**
     * @var UserRolesService
     */
    private $userRolesService;

    private $userProfileRepository;

    /**
     * SocialAuthService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserSocialsRepositoryInterface $userSocialsRepository
     * @param UserRolesService $userRolesService
     * @param UserProfileRepositoryInterface $userProfileRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserSocialsRepositoryInterface $userSocialsRepository,
        UserRolesService $userRolesService,
        UserProfileRepositoryInterface $userProfileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userSocialsRepository = $userSocialsRepository;
        $this->userRolesService = $userRolesService;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * @param User $socialUser
     * @param string $provider
     * @param string $platform
     * @throws \Exception
     */
    public function auth(User $socialUser, string $provider, string $platform): void
    {
        $userId = $this->findByProvider($socialUser->getId(), $provider);
        if (!empty($userId)) {
            $this->login($userId);
            return;
        }

        $userId = $this->findByEmail((string)$socialUser->getEmail());
        if (!empty($userId)) {
            $this->saveSocial($userId, $socialUser->getId(), $provider);
            $this->login($userId);
            return;
        }

        $userId = $this->createNewUser($socialUser, $provider, $platform);
        $this->login($userId);
    }

    /**
     * @param string $socialId
     * @param string $provider
     * @return int
     */
    private function findByProvider(string $socialId, string $provider): int
    {
        return $this->userSocialsRepository->findUserIdBySocialIdByProvider($socialId, $provider);
    }

    /**
     * @param string $email
     * @return int
     */
    private function findByEmail(string $email): int
    {
        if (empty($email)) {
            return 0;
        }

        return $this->userRepository->findIdByEmail($email);
    }

    /**
     * @param User $socialUser
     * @param string $provider
     * @return int
     * @throws \Exception
     */
    private function createNewUser(User $socialUser, string $provider, $platform): int
    {
        $user = $this->userRepository->save([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'sadvipra' => $platform === 'sadvipra',
            'registration_platform' => $platform
        ]);

        $user->markEmailAsVerified();

        $this->saveSocial($user->getId(), $socialUser->getId(), $provider);

        $this->userRolesService->attachRole($user, 'Sadhaka');

        $this->userProfileRepository->updateImage($user->id, $socialUser->getAvatar());

        return $user->getId();
    }

    /**
     * @param int $userId
     * @param string $socialId
     * @param string $provider
     */
    private function saveSocial(int $userId, string $socialId, string $provider): void
    {
        $this->userSocialsRepository->save([
            'user_id' => $userId,
            'social_id' => $socialId,
            'provider' => $provider,
        ]);
    }

    /**
     * @param int $userId
     */
    private function login(int $userId): void
    {
        auth()->loginUsingId($userId, true);
        $this->userRolesService->setDefaultHelperAcarya($userId);
    }
}
