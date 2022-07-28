<?php

namespace App\Services\Questions;

use App\Contracts\Questions\QuestionMessagesRepositoryInterface;
use App\Contracts\Questions\QuestionsRepositoryInterface;
use App\Contracts\User\UserProfileRepositoryInterface;
use App\Events\NewQuestionMessageAdded;
use App\Models\User\User;
use Carbon\Carbon;

class QuestionMessagesService
{
    /**
     * @var QuestionMessagesRepositoryInterface
     */
    private $questionMessagesRepository;
    /**
     * @var QuestionsRepositoryInterface
     */
    private $questionsRepository;

    /**
     * @var UserProfileRepositoryInterface
     */
    private $userProfileRepository;

    /**
     * QuestionMessagesService constructor.
     * @param QuestionMessagesRepositoryInterface $questionMessagesRepository
     * @param QuestionsRepositoryInterface $questionsRepository
     * @param UserProfileRepositoryInterface $userProfileRepository
     */
    public function __construct(
        QuestionMessagesRepositoryInterface $questionMessagesRepository,
        QuestionsRepositoryInterface $questionsRepository,
        UserProfileRepositoryInterface $userProfileRepository
    ) {
        $this->questionMessagesRepository = $questionMessagesRepository;
        $this->questionsRepository = $questionsRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * @param int $questionId
     * @param int $userId
     * @param string $text
     * @return bool
     * @throws \Exception
     */
    public function sendMessage(int $questionId, int $userId, string $text): bool
    {
        if (empty($question = $this->questionsRepository->getByIdByUserId($questionId, $userId))) {
            return false;
        }

        $this->questionsRepository->update($questionId, ['last_message_date' => Carbon::now()]);



        $result = $this->questionMessagesRepository->addQuestionMessage(
            [
                'question_id' => $questionId,
                'user_id' => $userId,
                'text' => strip_tags($text),
                'date' => Carbon::now()
            ]
        );



        return $result;
    }

    /**
     * @param int $questionId
     * @param int $userId
     * @param array $params
     * @return array
     */
    public function getQuestionMessages(int $questionId, int $userId, array $params = []): array
    {
        $chatMessages = $this->questionMessagesRepository->getQuestionMessages($questionId, $params);
        $userNames = [];

        foreach ($chatMessages as $key => $chatMessage) {
            if (empty($userNames[$chatMessage['user_id']])) {
                $userNames[$chatMessage['user_id']] = $this->userProfileRepository->findByUserId($chatMessage['user_id']);
            }

            $chatMessages[$key]['userNameCivil'] = $userNames[$chatMessage['user_id']]->first_name .' ' . $userNames[$chatMessage['user_id']]->last_name;
            $chatMessages[$key]['userNameSpirit'] = $userNames[$chatMessage['user_id']]->spiritual_name;
            $chatMessages[$key]['acarya'] = User::find($chatMessage['user_id'])->hasRole('acarya');

            unset($chatMessages[$key]['user_id']);
        }

        $this->questionMessagesRepository->markQuestionMessagesAsRead($questionId, $userId);

        return $chatMessages;
    }
}
