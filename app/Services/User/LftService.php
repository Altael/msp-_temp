<?php

namespace App\Services\User;

use App\Contracts\User\LftRepositoryInterface;

class LftService
{
    /**
     * @var LftRepositoryInterface
     */
    private $lftRepository;

    /**
     * LftService constructor.
     * @param LftRepositoryInterface $lftRepository
     */
    public function __construct(LftRepositoryInterface $lftRepository)
    {
        $this->lftRepository = $lftRepository;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function create(int $userId): bool
    {
        return $this->lftRepository->save(['user_id' => $userId]);
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function update(int $userId): bool
    {
        return $this->lftRepository->update($userId);
    }
}
