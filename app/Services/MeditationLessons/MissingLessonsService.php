<?php

namespace App\Services\MeditationLessons;

use App\Contracts\MeditationLessons\MeditationLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\MeditationLessonsServiceInterface;
use App\Contracts\MeditationLessons\MissingLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\MissingLessonsServiceInterface;
use App\Contracts\User\UserRolesRepositoryInterface;
use App\Contracts\User\UserTeachersRepositoryInterface;
use App\Events\LessonWasGiven;
use App\Models\MeditationLessons\LessonsRequests;
use App\Models\User\User;
use App\Models\User\UserProfile;
use App\Models\MeditationLessons\MeditationLessons;
use App\Models\User\UserTeachers;
use Carbon\Carbon;
use jeremykenedy\LaravelRoles\Models\Role;

class MissingLessonsService implements MissingLessonsServiceInterface
{
    /**
     * @var MissingLessonsRepositoryInterface
     */
    private $missingLessonsRepository;

    /**
     * MeditationLessonsService constructor.
     * @param MissingLessonsRepositoryInterface $missingLessonsRepository
     */
    public function __construct(
        MissingLessonsRepositoryInterface $missingLessonsRepository
    ) {
        $this->missingLessonsRepository = $missingLessonsRepository;
    }

    public function getUserMissingLesson(int $userId)
    {
        return \DB::transaction(function () use ($userId) {
            return $this->missingLessonsRepository->getUserMissingLesson($userId);
        });
    }

    /**
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function saveMissingRequest(int $userId, array $data): bool
    {
        $data['acarya_first']['id'] = $data['acarya_first']['id'] === 0 ? null : $data['acarya_first']['id'];
        $data['acarya_now']['id'] = $data['acarya_now']['id'] === 0 ? null : $data['acarya_now']['id'];

        $this->missingLessonsRepository->save([
            'user_id' => $userId,
            'lessons' => $data['lessons'],
            'acarya_first' => $data['acarya_first']['id'],
            'acarya_first_missing' => $data['acarya_first_missing'],
            'acarya_changed' => $data['acarya_changed'],
            'acarya_now' => $data['acarya_now']['id'],
            'acarya_missing' => $data['acarya_missing'],
            'initiation_date' => $data['initiation_date'],
            'status' => 1
        ]);

        $acarya_id = $data['acarya_changed'] || !$data['acarya_first']['id'] ? $data['acarya_now']['id'] : $data['acarya_first']['id'];

        if (!empty($acarya_id)) {
            UserTeachers::updateOrCreate(['user_id' => $userId], ['teacher_user_id' => $acarya_id]);
        }

        $newLessons = $data['lessons'];
        $oldLessons = $data['hadLessons'];

        foreach([6, 5, 4, 3, 2, 1] as $lesson) {
            if(in_array($lesson, $newLessons) && !in_array($lesson, $oldLessons)) {
                MeditationLessons::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'lesson_number' => $lesson,
                    ],
                    [
                        'from_user_id' => $lesson === '1' ? $data['acarya_first']['id'] : $acarya_id,
                        'receiving_date' => $lesson === 1 && $data['initiation_date'] ? $data['initiation_date'] : Carbon::today(),
                        'manual' => 1,
                        'date_indicated' => $lesson == '1' && $data['initiation_date']
                    ]
                );
            }
            if(!in_array($lesson, $newLessons) && in_array($lesson, $oldLessons)) {
                MeditationLessons::where('user_id', $userId)->where('lesson_number', $lesson)->delete();
                if($lesson === 1) UserTeachers::where('user_id', $userId)->delete();
            }
        }

        if($request = LessonsRequests::where('user_id', $userId)->where('status', 0)) {
            $request->delete();
        }

        if (request()->root() === env('AM_URL')) {
            $user = auth()->user();
            $role = Role::where('slug', 'margii')->value('id');
            $user->roles()->syncWithoutDetaching([$role]);
        }

        return true;
    }
}
