<?php

namespace App\Services\User;

use App\Contracts\Geolocation\DistrictAreaTasksRepositoryInterface;
use App\Contracts\User\UserProfileRepositoryInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Events\SpiritualNameChanged;
use App\Http\Traits\HistoryTrait;
use App\Models\Geolocation\DistrictArea;
use App\Models\User\User;
use App\Models\User\UserProfile;
use App\Services\Geolocation\UserPlacesService;
use Telegram\Bot\Laravel\Facades\Telegram;

class UserProfilesService
{
    use HistoryTrait;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserProfileRepositoryInterface
     */
    private $userProfileRepository;

    /**
     * @var UserPlacesService
     */
    private $userPlacesService;

    /**
     * @var DistrictAreaTasksRepositoryInterface
     */
    private $districtAreaTasksRepository;

    /**
     * UserProfilesService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserProfileRepositoryInterface $userProfileRepository
     * @param UserPlacesService $userPlacesService
     * @param DistrictAreaTasksRepositoryInterface $districtAreaTasksRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserProfileRepositoryInterface $userProfileRepository,
        UserPlacesService $userPlacesService,
        DistrictAreaTasksRepositoryInterface $districtAreaTasksRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->userPlacesService = $userPlacesService;
        $this->districtAreaTasksRepository = $districtAreaTasksRepository;
    }

    /**
     * @param int $userId
     * @return UserProfile
     */
    public function getProfile(int $userId): UserProfile
    {
        $result = $this->userProfileRepository->findByUserId($userId);
        if ($result !== null) {
            return $result;
        }

        return $this->userProfileRepository->save(['user_id' => $userId]);
    }

    /**
     * @param int $userId
     * @param array $data
     * @param bool $registrationCompleted
     * @throws \Exception
     */
    public function updateUserProfile(int $userId, array $data, bool $registrationCompleted): void
    {
        /*$this->updateUserPlaces($userId, $data['place_id'] ?? '');*/

        $this->userProfileRepository->update($userId, $data);

        $this->completeRegistration($userId, $registrationCompleted);
    }

    /**
     * @param int $userId
     * @param string $placeId
     * @throws \Exception
     */
    public function updateUserPlaces(int $userId, string $placeId): void
    {
        if (empty($placeId)) {
            return;
        }

        if(!count($this->userPlacesService->getByPlaceId($placeId))) {
            $this->userPlacesService->save($placeId);
        }
    }
    /**
     * @param int $userId
     * @param bool $registrationCompleted
     */
    private function completeRegistration(int $userId, bool $registrationCompleted): void
    {
        if ($registrationCompleted) {
            return;
        }

        $this->saveHistoryLog('user-registered');

        $this->userRepository->update($userId, ['registration_completed' => true]);
    }

    /**
     * @param int $userId
     * @param string $spiritualName
     * @param string $notes
     * @return bool
     */
    public function changeInitiationUser(int $userId, string $spiritualName, ?string $notes): bool
    {
        if($spiritualName !== User::findOrFail($userId)->profile->spiritual_name) {
            try {
                event(new SpiritualNameChanged($userId, $spiritualName));
            } catch (\Exception $e) {
                echo 'Сообщение человеку не отправлено';
            }
        }
        return $this->userProfileRepository->update($userId, ['spiritual_name' => $spiritualName, 'notes' => $notes]);
    }
}
