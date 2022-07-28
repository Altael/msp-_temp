<?php

namespace App\Services\User;

use App\Contracts\User\UserRepositoryInterface;
use App\Contracts\User\UserServiceInterface;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return User
     */
    public function save(array $data): User
    {
        $data['password'] = $this->hashPassword($data['password']);
        return $this->userRepository->save($data);
    }

    /**
     * @param string $password
     * @return string
     */
    private function hashPassword(string $password): string
    {
        return Hash::make($password);
    }
}
