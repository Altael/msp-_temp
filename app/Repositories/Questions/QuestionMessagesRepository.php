<?php

namespace App\Repositories\Questions;

use App\Contracts\Questions\QuestionMessagesRepositoryInterface;
use App\Events\NewQuestionMessageAdded;
use App\Models\Questions\QuestionMessages;
use App\Models\Questions\Questions;
use App\Models\User\User;

class QuestionMessagesRepository implements QuestionMessagesRepositoryInterface
{
    /**
     * @param int $questionId
     * @param int $userId
     * @return int
     */
    public function getUnreadCountByQuestionId(int $questionId, int $userId): int
    {
        return QuestionMessages
            ::where('question_id', $questionId)
            ->where('user_id', '!=', $userId)
            ->where('status', 0)
            ->get()
            ->count();
    }

    /**
     * @param int $questionId
     * @return string
     */
    public function getLastMessageByQuestionId(int $questionId): string
    {
        return QuestionMessages
            ::where('question_id', $questionId)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->value('text');
    }

    /**
     * @param int $questionId
     * @param array $params
     * @return array
     */
    public function getQuestionMessages(int $questionId, array $params = []): array
    {
        return QuestionMessages::query()
            ->join('users as u', 'u.id', '=', 'question_messages.user_id')
            ->join('user_profiles as up', 'up.user_id', '=', 'question_messages.user_id')
            ->select(
                'question_messages.user_id',
                'text',
                'date',
                'up.image as userAvatar',
                'up.email as userEmail'
            )
            ->where('question_id', $questionId)
            ->orderBy('question_messages.id', $params['orderType'] ?? 'DESC')
            ->get()
            ->toArray();
    }

    /**
     * @inheritDoc
     */
    public function markQuestionMessagesAsRead(int $questionId, int $userId): bool
    {
        return (bool)QuestionMessages
            ::where('question_id', $questionId)
            ->where('user_id', '!=', $userId)
            ->update(['status' => 1]);
    }

    /**
     * @inheritDoc
     */
    public function addQuestionMessage(array $data): bool
    {
        $status = (bool)QuestionMessages::create($data);

        $dialogue = Questions::where('id', $data['question_id']);
        $dialogue_user_1 = $dialogue->value('from_user_id');
        $dialogue_user_2 = $dialogue->value('to_user_id');

        $to_user_id = $data['user_id'] === $dialogue_user_1 ? $dialogue_user_2 : $dialogue_user_1;

        $is_acarya = User::where('id', $to_user_id)->first()->hasRole('acarya');

        $data += [
            'is_acarya' => $is_acarya
        ];

        if ($status) {

            try {
                event(new NewQuestionMessageAdded($data));
            } catch (\Exception $e) {
                echo 'Сообщение не было отправлено, переподключите телеграм';
            }
        }

        return $status;

    }
}
