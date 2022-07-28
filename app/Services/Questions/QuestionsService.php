<?php

namespace App\Services\Questions;

use App\Contracts\Questions\QuestionMessagesRepositoryInterface;
use App\Contracts\Questions\QuestionsRepositoryInterface;
use App\Contracts\User\UserTeachersRepositoryInterface;
use App\Models\User\User;

class QuestionsService
{
    private const QUESTION_STATUSES = [
        0 => 'awaiting_reply',
        1 => 'in_progress',
        2 => 'decided'
    ];

    /**
     * @var QuestionsRepositoryInterface
     */
    private $questionsRepository;

    /**
     * @var QuestionMessagesRepositoryInterface
     */
    private $questionMessagesRepository;

    /**
     * @var UserTeachersRepositoryInterface
     */
    private $teachersRepository;

    /**
     * QuestionsService constructor.
     * @param QuestionsRepositoryInterface $questionsRepository
     * @param QuestionMessagesRepositoryInterface $questionMessagesRepository
     * @param UserTeachersRepositoryInterface $teachersRepository
     */
    public function __construct(
        QuestionsRepositoryInterface $questionsRepository,
        QuestionMessagesRepositoryInterface $questionMessagesRepository,
        UserTeachersRepositoryInterface $teachersRepository
    ) {
        $this->questionsRepository = $questionsRepository;
        $this->questionMessagesRepository = $questionMessagesRepository;
        $this->teachersRepository = $teachersRepository;
    }

    /**
     * @param int $fromUserId
     * @param string $subject
     * @return int
     * @throws \Exception
     */
    public function saveQuestion(int $fromUserId, string $subject): int
    {
        return $this->questionsRepository->save([
            'from_user_id' => $fromUserId,
            'to_user_id' => $this->teachersRepository->getTeacherIdByUserId($fromUserId),
            'subject' => $subject,
            'last_message_date' => new \DateTime(),
        ]);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getQuestions(int $userId): array
    {
        $questions = $this->questionsRepository->getAllByUserId($userId);
        $result = [];

        foreach ($questions as $question) {
            $question['unread'] = $this->questionMessagesRepository->getUnreadCountByQuestionId(
                $question['id'],
                $userId
            );
            if($question['status'] !== 2) $question['status'] = $question['unread'] ? 0 : 1;

            $question['last_message'] = $this->questionMessagesRepository->getLastMessageByQuestionId($question['id']);
            $question['userName'] = User::find($question['userId'])->profile->displayName;

            $result[self::QUESTION_STATUSES[$question['status']]][] = $question;
        }

        return $result;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getLatestQuestionDate(int $userId): string
    {
        $result = $this->questionsRepository->getLatestByUserId($userId);

        return $result;
    }

    /**
     * @param int $id
     * @param int $userId
     * @param int $status
     * @return bool
     */
    public function changeStatus(int $id, int $userId, int $status): bool
    {
        if (empty($this->questionsRepository->getByIdByUserId($id, $userId))) {
            return false;
        }

        return $this->questionsRepository->update($id, ['status' => $status]);
    }
}
