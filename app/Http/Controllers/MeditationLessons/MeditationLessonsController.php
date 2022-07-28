<?php

namespace App\Http\Controllers\MeditationLessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeditationLessons\ActionLessonRequest;
use App\Http\Requests\MeditationLessons\DelegateLessonRequest;
use App\Http\Requests\MeditationLessons\GetAllLessonRequest;
use App\Http\Requests\MeditationLessons\GetFromUserLessonsRequest;
use App\Http\Requests\MeditationLessons\SaveLessonRequest;
use App\Http\Requests\MeditationLessons\SaveMissingRequest;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Http\Traits\AcaryaHelperTrait;
use App\LessonRequirement;
use App\MissingLesson;
use App\Models\MeditationLessons\MeditationLessons;
use App\Models\User\UserPlaces;
use App\Models\User\UserTeachers;
use App\Repositories\User\UserRepository;
use App\Services\MeditationLessons\LessonsRequestsService;
use App\Services\MeditationLessons\MeditationLessonsService;
use App\Services\MeditationLessons\MissingLessonsService;
use Illuminate\Http\JsonResponse;

class MeditationLessonsController extends Controller
{
    use AcaryaHelperTrait;

    /**
     * @param MeditationLessonsService $meditationLessonsService
     * @param LessonsRequestsService $lessonsRequestsService
     * @param MissingLessonsService $missingLessonsService
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function getLastUserLesson(
        MeditationLessonsService $meditationLessonsService,
        LessonsRequestsService $lessonsRequestsService,
        MissingLessonsService $missingLessonsService,
        UserRepository $userRepository
    ): JsonResponse {
        $user = auth()->user();
        $userId = $user->id;
        return response()->json([
            'lastUserLesson' => $meditationLessonsService->getLastUserLesson($userId),
            'userLessons' => $meditationLessonsService->getUserLessons($userId)->pluck('lesson_number'),
            'activeUserRequests' => $lessonsRequestsService->getActiveUserRequests($userId),
            'missingLessonRequest' => $missingLessonsService->getUserMissingLesson($userId),
            'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryas()->where('hidden', 0)),
            'reqs' => ($teacher = auth()->user()->teacher) ? LessonRequirement::where('acarya_id', $teacher->id)->get() : [],
            'isUkraine' => $user->districtArea ? $user->districtArea->district ? $user->districtArea->district->diocese ? $user->districtArea->district->diocese->id === 4 : false : false : false,
            'current_acarya' => $user->teachers()->first() ? ['id' => $user->teachers()->first()->id, 'name' => $user->teachers()->first()->displayName] : null,
            'sex' => $user->profile ? $user->profile->sex : 'male'
        ]);
    }

    /**
     * @param MeditationLessonsService $meditationLessonsService
     * @param LessonsRequestsService $lessonsRequestsService
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function getUserLessons(
        MeditationLessonsService $meditationLessonsService,
        LessonsRequestsService $lessonsRequestsService,
        UserRepository $userRepository
    ): JsonResponse {
        return response()->json([
            'acaryas' => UserIdDisplayNameResource::collection($userRepository->getAllAcaryasBySex()->where('hidden', 0)),
            'lessons' => $meditationLessonsService->getUserLessons(auth()->user()->id)
        ]);
    }

    /**
     * @param GetFromUserLessonsRequest $getFromUserLessonsRequest
     * @param MeditationLessonsService $meditationLessonsService
     * @return JsonResponse
     */
    public function getFromUserLastLessons(
        GetFromUserLessonsRequest $getFromUserLessonsRequest,
        MeditationLessonsService $meditationLessonsService
    ): JsonResponse {
        $countries = UserPlaces::all()->pluck('country');

        $result = response()->json([
            'result' => $meditationLessonsService->getFromUserLastLessons(
                $this->getUserId(),
                array_merge($getFromUserLessonsRequest->all(), ['lang' => auth()->user()->language ?? 'ru'])
            ),
            'countries' => $countries
        ]);

        return $result;
    }

    /**
     * @param GetAllLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @return int
     */
    public function getLessonsCount(
        GetAllLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService
    ): int {
        $result = $lessonsRequestsService->getAll(
                auth()->user()->id,
                array_merge($request->all(), ['lang' => auth()->user()->language ?? 'ru'])
        )['total'];
        return $result;
    }

    /**
     * @param GetAllLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @return int
     */
    public function getInitiationsCount(
        GetAllLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService
    ): int {
        $result = $lessonsRequestsService->getAll(
            auth()->user()->id,
            ['status' => 0, 'lesson' => 1, 'lang' => auth()->user()->language ?? 'ru', 'type' => 'get']
        )['total'];
        return $result;
    }

    /**
     * @param GetAllLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @return JsonResponse
     */
    public function getAllLessonRequests(
        GetAllLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService
    ): JsonResponse {
        $response = response()->json([
            'result' => $lessonsRequestsService->getAll(
                $this->getUserId(),
                array_merge($request->all(), ['lang' => auth()->user()->language ?? 'ru'])
            ),
            'meta' => [
                'isHelper' => auth()->user()->hasRole('helper'),
            ]
        ]);
        return $response;
    }

    /**
     * @param SaveLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @return JsonResponse
     */
    public function saveLessonRequest(
        SaveLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService
    ): JsonResponse {
        $result = $lessonsRequestsService->saveLessonRequest(auth()->user()->id, $request->all());
        return response()->json(['result' => $result]);
    }

    public function saveMissingRequest(
        SaveMissingRequest $request,
        MissingLessonsService $missingLessonsService
    ): JsonResponse {
        $result = $missingLessonsService->saveMissingRequest(auth()->user()->id, $request->all());
        return response()->json(['result' => $result]);
    }

    /**
     * @param ActionLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @param MeditationLessonsService $meditationLessonsService
     * @return JsonResponse
     */
    public function approveLessonRequest(
        ActionLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService,
        MeditationLessonsService $meditationLessonsService
    ): JsonResponse {
        $lessonRequest = $lessonsRequestsService->changeStatus($request->get('id'), $request->get('spiritual_name'), $request->get('notes'));
        if (empty($lessonRequest)) {
            return response()->json(['result' => false]);
        }

        if ($lessonRequest['type'] === 'get') {
            $meditationLessonsService->saveUserLesson(
                $lessonRequest['user_id'],
                $lessonRequest['lesson'],
                $this->getUserId()
            );
        }

        return response()->json(['result' => true]);
    }

    /**
     * @param ActionLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @param MeditationLessonsService $meditationLessonsService
     * @return JsonResponse
     */
    public function cancelLessonRequest(
        ActionLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService,
        MeditationLessonsService $meditationLessonsService
    ): JsonResponse {
        $lessonRequest = $lessonsRequestsService->changeStatus($request->get('id'), 0);
        if (empty($lessonRequest)) {
            return response()->json(['result' => false]);
        }

        $meditationLessonsService->delete($lessonRequest['user_id'], $lessonRequest['lesson']);
        return response()->json(['result' => true]);
    }

    /**
     * @param ActionLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @return JsonResponse
     */
    public function deleteLessonRequest(
        ActionLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService
    ): JsonResponse {
        return response()->json(['result' => $lessonsRequestsService->delete($request->get('id'))]);
    }

    /**
     * @param DelegateLessonRequest $request
     * @param LessonsRequestsService $lessonsRequestsService
     * @return JsonResponse
     */
    public function delegateLessonRequest(
        DelegateLessonRequest $request,
        LessonsRequestsService $lessonsRequestsService
    ): JsonResponse {
        $result = $lessonsRequestsService->delegateLessonRequest($request->get('id'), $request->get('userId'));
        return response()->json(['result' => $result]);
    }

    public function saveUserLessons()
    {
        $lessons = request('lessons');

        foreach($lessons as $lesson) {
            MeditationLessons::where('user_id', auth()->user()->id)
                ->where('lesson_number', $lesson['lesson_number'])
                ->update([
                    'receiving_date' => $lesson['receiving_date'],
                    'from_user_id' => $lesson['teacher']['id']
                ]);
        }

        return [
            'status' => 'ok'
        ];
    }
}
