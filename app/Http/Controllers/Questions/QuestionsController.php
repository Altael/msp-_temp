<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questions\GetQuestionMessagesRequest;
use App\Http\Requests\Questions\SaveQuestionMessageRequest;
use App\Http\Requests\Questions\SaveQuestionRequest;
use App\Http\Requests\Questions\UpdateQuestionStatusRequest;
use App\Http\Traits\AcaryaHelperTrait;
use App\Models\Questions\Questions;
use Carbon\Carbon;
use App\Services\Questions\QuestionMessagesService;
use App\Services\Questions\QuestionsService;
use http\Env\Response;

class QuestionsController extends Controller
{
    use AcaryaHelperTrait;

    /**
     * @param QuestionsService $questionsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions(QuestionsService $questionsService): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'result' => $questionsService->getQuestions($this->getUserId()),
        ]);
    }

    /**
     * @param QuestionsService $questionsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestionDates(QuestionsService $questionsService): \Illuminate\Http\JsonResponse
    {
        if(Questions::where('from_user_id', auth()->user()->id)->exists()) {
            $latestDate = Carbon::createFromFormat('Y-m-d H:i:s', $questionsService->getLatestQuestionDate(auth()->user()->id));
        } else {
            $latestDate = Carbon::minValue();
        }
        $currentDate = Carbon::now();

       return response()->json([
           'daysDifference' => $latestDate->diffInDays($currentDate),
           'messageAt' => $latestDate->add(7, 'day')->toDateTimeString(),
           'hasLesson' => boolval(auth()->user()->currentLesson)
       ]);
    }

    /**
     * @param SaveQuestionRequest $questionRequest
     * @param QuestionsService $questionsService
     * @param QuestionMessagesService $questionMessagesService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function saveQuestion(
        SaveQuestionRequest $questionRequest,
        QuestionsService $questionsService,
        QuestionMessagesService $questionMessagesService
    ): \Illuminate\Http\JsonResponse {

        $latestDate = Carbon::createFromFormat('Y-m-d H:i:s', $questionsService->getLatestQuestionDate(auth()->user()->id));
        $currentDate = Carbon::now();

        if($latestDate->diffInDays($currentDate) < 7) {
            return response()->json(['error' => 'Too fast messaging']);
        }

        $questionId = $questionsService->saveQuestion(auth()->user()->id, $questionRequest->get('subject'));
        $result = $questionMessagesService->sendMessage(
            $questionId,
            auth()->user()->id,
            $questionRequest->get('message')
        );
        return response()->json(['result' => $result]);
    }

    /**
     * @param SaveQuestionMessageRequest $questionMessageRequest
     * @param QuestionMessagesService $questionMessagesService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function saveMessage(
        SaveQuestionMessageRequest $questionMessageRequest,
        QuestionMessagesService $questionMessagesService
    ): \Illuminate\Http\JsonResponse {
        $user = auth()->user();
        $userId = $user->id;
        $userNameCivil = $user->profile->first_name . ' ' . $user->profile->last_name;
        $userNameSpirit = $user->profile->spiritual_name;
        $userEmail = $user->profile->email;
        $userAvatar = $user->profile->image;
        if (strpos($questionMessageRequest->server('HTTP_REFERER'), 'user/conversations') === false) {
            $userId = $this->getUserId();
            $userNameSpirit = $this->getUserName();
        }

        $questionMessagesService->sendMessage(
            $questionMessageRequest->get('questionId'),
            $userId,
            $questionMessageRequest->get('message')
        );

        $result = [
            'userNameCivil' => $userNameCivil,
            'userNameSpirit' => $userNameSpirit,
            'text' => $questionMessageRequest->get('message'),
            'date' => date('Y-m-d H:i:s'),
            'userEmail' => $userEmail,
            'userAvatar' => $userAvatar
        ];

        return response()->json(['result' => $result]);
    }

    /**
     * @param GetQuestionMessagesRequest $getQuestionMessagesRequest
     * @param QuestionMessagesService $questionMessagesService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestionMessages(
        GetQuestionMessagesRequest $getQuestionMessagesRequest,
        QuestionMessagesService $questionMessagesService
    ): \Illuminate\Http\JsonResponse {
        $result = $questionMessagesService->getQuestionMessages(
            $getQuestionMessagesRequest->get('questionId'),
            auth()->id(),
            $getQuestionMessagesRequest->all()
        );

        return response()->json(['result' => $result]);
    }

    /**
     * @param UpdateQuestionStatusRequest $updateQuestionStatusRequest
     * @param QuestionsService $questionsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuestionStatus(
        UpdateQuestionStatusRequest $updateQuestionStatusRequest,
        QuestionsService $questionsService
    ): \Illuminate\Http\JsonResponse {
        $result = $questionsService->changeStatus(
            $updateQuestionStatusRequest->get('questionId'),
            $this->getUserId(),
            $updateQuestionStatusRequest->get('status')
        );

        return response()->json(['result' => $result]);
    }

    public function unreadMessageCount()
    {
        return [
            'status' => 'ok',
            'count' => auth()->user()->unreadMessageCount
        ];
    }
}
