<?php

namespace App\Services\MeditationLessons;

use App\Contracts\MeditationLessons\MeditationLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\MeditationLessonsServiceInterface;
use App\Contracts\User\UserRolesRepositoryInterface;
use App\Contracts\User\UserTeachersRepositoryInterface;
use App\Events\LessonWasGiven;
use App\Http\Resources\InitiationDetailsResource;
use App\Http\Resources\MeditationLessonsResource;
use App\Models\User\User;
use App\Models\User\UserProfile;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MeditationLessonsService implements MeditationLessonsServiceInterface
{
    /**
     * @var MeditationLessonsRepositoryInterface
     */
    private $meditationLessonsRepository;

    /**
     * @var UserTeachersRepositoryInterface
     */
    private $userTeachersRepository;

    /**
     * @var UserRolesRepositoryInterface
     */
    private $userRolesRepository;


    /**
     * MeditationLessonsService constructor.
     * @param MeditationLessonsRepositoryInterface $meditationLessonsRepository
     * @param UserTeachersRepositoryInterface $userTeachersRepository
     */
    public function __construct(
        MeditationLessonsRepositoryInterface $meditationLessonsRepository,
        UserTeachersRepositoryInterface $userTeachersRepository,
        UserRolesRepositoryInterface $userRolesRepository
    ) {
        $this->meditationLessonsRepository = $meditationLessonsRepository;
        $this->userTeachersRepository = $userTeachersRepository;
        $this->userRolesRepository = $userRolesRepository;
    }

    /**
     * @param int $userId
     * @param int $lessonNumber
     * @param int $fromUserId
     * @param bool $manual
     * @return bool
     */
    public function saveUserLesson(int $userId, int $lessonNumber, int $fromUserId = 0, bool $manual = false): bool
    {
        if ($lessonNumber === 1 && !empty($fromUserId)) {
            $this->userTeachersRepository->save(['user_id' => $userId, 'teacher_user_id' => $fromUserId]);
        }

        return \DB::transaction(function () use ($userId, $lessonNumber, $fromUserId, $manual) {
            $result = $this->meditationLessonsRepository->save([
                'user_id' => $userId,
                'lesson_number' => $lessonNumber,
                'from_user_id' => $fromUserId,
                'manual' => $manual
            ]);

            try {
                event(new LessonWasGiven($userId, $lessonNumber));
            } catch (\Exception $e) {

            }

            return $result;
        });

    }

    /**
     * @param int $userId
     * @return int
     */
    public function getLastUserLesson(int $userId): int
    {
        return $this->meditationLessonsRepository->getLastUserLesson($userId);
    }

    /**
     * @param int $userId
     * @return AnonymousResourceCollection
     */
    public function getUserLessons(int $userId)
    {
        return MeditationLessonsResource::collection($this->meditationLessonsRepository->getUserLessons($userId)->sortBy('lesson_number'));
    }

    /**
     * @param int $userId
     * @param array $filter
     * @return array
     */
    public function getFromUserLastLessons(int $userId, array $filter = []): array
    {
        $lessons = $this->meditationLessonsRepository->getFromUserLastLessons($userId, $filter);
        $total = $this->meditationLessonsRepository->getCount($userId, $filter);

        foreach($lessons as $key => $lesson){
            $userId = $lessons[$key]['userId'];

            $roles = $this->userRolesRepository->getRolesByUserId($userId);
            $lessons[$key]['roles'] = $roles;

            $prevLessons = InitiationDetailsResource::collection($this->meditationLessonsRepository->getUserLessons($userId));

            $lessons[$key]['prev_lessons'] = $prevLessons;
            /*foreach($lessons[$key]['prev_lessons'] as $key2 => $prev_lesson) {
                $lessons[$key]['prev_lessons'][$key2]['teacher'] = optional(UserProfile::where('user_id', $lessons[$key]['prev_lessons'][$key2]['teacher'])->first())->displayName;
            }*/
        }

        return [
            'lessons' => $lessons,
            'total' => $total
        ];
    }

    /**
     * @param int $userId
     * @param int $lesson
     * @return bool
     */
    public function delete(int $userId, int $lesson): bool
    {
        return (bool)$this->meditationLessonsRepository->delete($userId, $lesson);
    }
}
