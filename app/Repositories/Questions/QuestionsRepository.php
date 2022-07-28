<?php

namespace App\Repositories\Questions;

use App\Contracts\Questions\QuestionsRepositoryInterface;
use App\Models\Questions\Questions;
use Carbon\Carbon;

class QuestionsRepository implements QuestionsRepositoryInterface
{
    /**
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        return (int)Questions::create($data)->id;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getAllByUserId(int $userId): array
    {
        return Questions
            ::join('users as u', 'u.id', '=', 'questions.from_user_id')
            ->join('user_profiles as up', 'up.user_id', '=', 'u.id')
            ->select(
                'u.id as userId',
                'u.name as userName',
                'up.image as userAvatar',
                'questions.id',
                'questions.subject',
                'questions.status',
                'questions.last_message_date',
                'questions.created_at as questionDate'
            )
            ->where('from_user_id', $userId)
            ->orWhere('to_user_id', $userId)
            ->orderBy('last_message_date', 'DESC')
            ->get()
            ->toArray();
    }

    public function getLatestByUserId(int $userId): Carbon
    {
        $result = Carbon::minValue();
        if(Questions::where('from_user_id', $userId)->first()) {
            $result = Questions
                ::where('from_user_id', $userId)
                ->latest('created_at')
                ->first()
                ->toArray();
            $result = Carbon::create($result['created_at']);
        }
        return $result;
    }

    public function getByIdByUserId(int $id, int $userId): array
    {
        return Questions
            ::where('id', $id)
            ->where(static function ($q) use ($userId) {
                $q
                    ->where('from_user_id', $userId)
                    ->orWhere('to_user_id', $userId);
            })
            ->first()
            ->toArray();
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return (bool)Questions
            ::where('id', $id)
            ->update($data);
    }
}
