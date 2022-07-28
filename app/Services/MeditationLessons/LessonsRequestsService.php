<?php

namespace App\Services\MeditationLessons;

use App\Contracts\MeditationLessons\DelegatedLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\LessonsRequestsRepositoryInterface;
use App\Events\SpiritualNameChanged;
use App\Models\MeditationLessons\LessonsRequests;
use App\Models\User\User;
use App\Services\Geolocation\AcaryaGeoService;

class LessonsRequestsService
{
    /**
     * @var LessonsRequestsRepositoryInterface
     */
    private $lessonsRequestsRepository;

    /**
     * @var AcaryaGeoService
     */
    private $acaryaGeoService;

    /**
     * @var DelegatedLessonsRepositoryInterface
     */
    private $delegatedLessonsRepository;

    /**
     * LessonsRequestsService constructor.
     * @param LessonsRequestsRepositoryInterface $lessonsRequestsRepository
     * @param AcaryaGeoService $acaryaGeoService
     * @param DelegatedLessonsRepositoryInterface $delegatedLessonsRepository
     */
    public function __construct(
        LessonsRequestsRepositoryInterface $lessonsRequestsRepository,
        AcaryaGeoService $acaryaGeoService,
        DelegatedLessonsRepositoryInterface $delegatedLessonsRepository
    ) {
        $this->lessonsRequestsRepository = $lessonsRequestsRepository;
        $this->acaryaGeoService = $acaryaGeoService;
        $this->delegatedLessonsRepository = $delegatedLessonsRepository;
    }

    /**
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function saveLessonRequest(int $userId, array $data): bool
    {
        foreach ($data['lessons'] as $lesson) {
            $this->lessonsRequestsRepository->save([
                'user_id' => $userId,
                'lesson' => $lesson,
                'type' => $data['type'],
                'meditation_hours' => $data['meditation_hours'] ?? 0
            ]);
        }

        return true;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getActiveUserRequests(int $userId): array
    {
        return $this->lessonsRequestsRepository->getActiveUserRequests($userId);
    }

    /**
     * @param int $userId
     * @param array $filter
     * @return array
     */
    public function getAll(int $userId, array $filter): array
    {
        $geoRegions = $this->acaryaGeoService->getGeoLocations($userId);
        if (empty($geoRegions)) {
            return ['requests' => [], 'total' => 0];
        }

        $filter['userId'] = $userId;
        $filter['sex'] = User::findOrFail($userId)->profile['sex'];

        $result = [
            'requests' => $this->lessonsRequestsRepository->getAll($filter, $geoRegions)['requests'],
            'total' => $this->lessonsRequestsRepository->getAll($filter, $geoRegions)['total'],
        ];

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool)$this->lessonsRequestsRepository->delete($id);
    }

    /**
     * @param int $id
     * @param string $spiritual_name
     * @param string $notes
     * @param int $status
     * @return array
     */
    public function changeStatus(int $id, ?string $spiritual_name, ?string $notes = ' ', int $status = 1): array
    {
        if (empty($request = $this->lessonsRequestsRepository->getById($id))) {
            return [];
        }

        $user = User::findOrFail(LessonsRequests::findOrFail($id)->user_id);

        if($spiritual_name !== $user->profile->spiritual_name) event(new SpiritualNameChanged($user->id, $spiritual_name));
        $this->lessonsRequestsRepository->update($id, ['status' => $status, 'spiritual_name' => $spiritual_name, 'notes' => $notes]);


        if ($status === 1) {
            $this->delegatedLessonsRepository->delete($id);
        }

        return $request;
    }

    /**
     * @param int $userId
     * @param int $lessonRequestId
     * @return bool
     */
    public function delegateLessonRequest(int $lessonRequestId, int $userId): bool
    {
        return $this->delegatedLessonsRepository->save([
            'user_id' => $userId,
            'lesson_request_id' => $lessonRequestId
        ]);
    }
}
