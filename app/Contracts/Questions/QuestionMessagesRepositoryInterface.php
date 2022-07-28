<?php

namespace App\Contracts\Questions;

interface QuestionMessagesRepositoryInterface
{
    /**
     * @param int $questionId
     * @param int $userId
     * @return int
     */
    public function getUnreadCountByQuestionId(int $questionId, int $userId): int;

    /**
     * @param int $questionId
     * @param array $params
     * @return array
     */
    public function getQuestionMessages(int $questionId, array $params = []): array;

    /**
     * @param int $questionId
     * @param int $userId
     * @return bool
     */
    public function markQuestionMessagesAsRead(int $questionId, int $userId): bool;

    /**
     * @param array $data
     * @return bool
     */
    public function addQuestionMessage(array $data): bool;

    /**
     * @param int $questionId
     * @return string
     */
    public function getLastMessageByQuestionId(int $questionId): string;
}
