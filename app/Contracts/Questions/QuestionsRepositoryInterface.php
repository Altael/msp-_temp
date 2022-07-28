<?php

namespace App\Contracts\Questions;

use Carbon\Carbon;

interface QuestionsRepositoryInterface
{
    /**
     * @param array $data
     * @return int
     */
    public function save(array $data): int;

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * @param int $userId
     * @return array
     */
    public function getAllByUserId(int $userId): array;

    /**
     * @param int $userId
     * @return array
     */
    public function getLatestByUserId(int $userId): Carbon;

    /**
     * @param int $id
     * @param int $userId
     * @return array
     */
    public function getByIdByUserId(int $id, int $userId): array;
}
