<?php

namespace App\Services\Geolocation;

use App\Contracts\Geolocation\DistrictAreaTasksRepositoryInterface;
use App\Contracts\User\UserRepositoryInterface;
use App\Models\User\User;
use Carbon\Carbon;

class FindDistrictAreaService
{
    /**
     * @var DistrictAreaTasksRepositoryInterface
     */
    private $districtAreaTasksRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var DistrictAreaService
     */
    private $districtAreaService;

    /**
     * FindDistrictAreaService constructor.
     * @param DistrictAreaTasksRepositoryInterface $districtAreaTasksRepository
     * @param UserRepositoryInterface $userRepository
     * @param DistrictAreaService $districtAreaService
     */
    public function __construct(
        DistrictAreaTasksRepositoryInterface $districtAreaTasksRepository,
        UserRepositoryInterface $userRepository,
        DistrictAreaService $districtAreaService
    ) {
        $this->districtAreaTasksRepository = $districtAreaTasksRepository;
        $this->userRepository = $userRepository;
        $this->districtAreaService = $districtAreaService;
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $tasks = $this->districtAreaTasksRepository->getAll();
        foreach ($tasks as $task) {
            if ($task['type'] === 'district_area') {
                $this->findUsersByDistrictArea(json_decode($task['task'], true));
            }

            if ($task['type'] === 'user') {
                $this->findDistrictAreaByUser(json_decode($task['task'], true));
            }
        }

        $this->districtAreaTasksRepository->deleteByIds(array_pluck($tasks, 'id'));
    }

    public function run()
    {
        User::whereNull('district_area_id')->whereHas('profile', function ($query) {
                $query->whereNotNull('place_id');
        })->chunk(200, function ($users) {
            foreach ($users as $user) {
                if(!in_array($user->id, [154, 173, 189, 190, 205, 207, 317, 326, 331, 336, 416, 599, 621, 839, 849, 1004, 1089, 1118, 1188, 1195, 1213, 1221, 1590, 1592, 1622, 1628, 1759, 1760, 2034, 2492, 3056, 3079, 3284, 3302, 3349, 3439, 3487])) {
                    $time = Carbon::now()->toTimeString();
                    file_put_contents('log_maps_api.txt', "Another one bites the dust: {$user->id} on {$time}".PHP_EOL, FILE_APPEND);

                    $districtAreaId = $this->districtAreaService->findByPlaceId($user->profile->place_id);

                    if ($districtAreaId) {
                        echo "User: {$user->name}\nPlace: {$user->profile->place->name}\nArea: {$districtAreaId}\n\n";
                        $user->update([
                            'district_area_id' => $districtAreaId
                        ]);
                    }

                    file_put_contents('log_maps_api.txt', "-------------------------".PHP_EOL, FILE_APPEND);
                }
            }

        });
    }

    /**
     * @param array $districtArea
     * @throws \Exception
     */
    private function findUsersByDistrictArea(array $districtArea): void
    {
        $types = $this->getAvailableDistrictAreasTypes($districtArea['type']);
        $users = $this->userRepository->findUsersByDistrictAreaTypes($types);
        if (empty($users)) {
            return;
        }

        foreach ($users as $user) {
            $districtAreaId = $this->districtAreaService->findByPlaceId($user['placeId'], $districtArea);
            if (empty($districtAreaId)) {
                continue;
            }

            $this->userRepository->update($user['id'], ['district_area_id' => $districtAreaId]);
        }
    }

    /**
     * @param string $type
     * @return array
     */
    private function getAvailableDistrictAreasTypes(string $type): array
    {
        if ($type === 'city') {
            return [
                'region',
                'country'
            ];
        }

        if ($type === 'region') {
            return [
                'country'
            ];
        }

        return [];
    }

    /**
     * @param array $user
     * @throws \Exception
     */
    private function findDistrictAreaByUser(array $user): void
    {
        $districtAreaId = $this->districtAreaService->findByPlaceId($user['placeId']);
        if (empty($districtAreaId)) {
            return;
        }

        $this->userRepository->update($user['id'], ['district_area_id' => $districtAreaId]);
    }
}
