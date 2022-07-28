<?php

namespace App\Repositories\MeditationLessons;

use App\Contracts\MeditationLessons\DelegatedLessonsRepositoryInterface;
use App\Http\Traits\HistoryTrait;
use App\Models\MeditationLessons\DelegatedLessons;

class DelegatedLessonsRepository implements DelegatedLessonsRepositoryInterface
{
    use HistoryTrait;

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        $delegate = DelegatedLessons::create($data);

        $this->saveHistoryLog('lesson-request-delegated', $delegate);

        return (bool)$delegate;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return DelegatedLessons::query()
            ->where('lesson_request_id', '=', $id)
            ->delete();
    }
}
