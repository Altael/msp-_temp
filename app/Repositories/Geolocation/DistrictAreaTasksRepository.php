<?php

namespace App\Repositories\Geolocation;

use App\Contracts\Geolocation\DistrictAreaTasksRepositoryInterface;
use App\Models\Geolocation\DistrictAreaTasks;

class DistrictAreaTasksRepository implements DistrictAreaTasksRepositoryInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        return (bool)DistrictAreaTasks::create($data);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return DistrictAreaTasks::get()
            ->toArray();
    }

    /**
     * @param array $ids
     * @return int
     */
    public function deleteByIds(array $ids): int
    {
        return DistrictAreaTasks
            ::whereIn('id', $ids)
            ->delete();
    }

}
