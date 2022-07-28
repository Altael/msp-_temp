<?php

namespace App\Repositories\MeditationLessons;

use App\Contracts\MeditationLessons\LessonsRequestsRepositoryInterface;
use App\Events\NewLessonRequestAdded;
use App\Http\Resources\LessonRequestsResource;
use App\Http\Traits\HistoryTrait;
use App\Models\MeditationLessons\LessonsRequests;
use App\Services\Geolocation\GeolocationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LessonsRequestsRepository implements LessonsRequestsRepositoryInterface
{
    use HistoryTrait;

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return LessonsRequests
            ::where('id', $id)
            ->first()
            ->toArray();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        $request = LessonsRequests::create($data);

        $this->saveHistoryLog('lesson-request-open', $request);

        $status =  (bool)$request;

        try {
            event(new NewLessonRequestAdded($request));
        } catch (\Exception $e) {
            echo 'Сообщение ачарье не было отправлено, ему надо переподключить телеграм';
        }

        return $status;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $request = LessonsRequests::where('lessons_requests.id', $id)
            ->join('user_profiles as up', 'up.user_id', '=', 'lessons_requests.user_id')
            ->join('users as u', 'u.id', '=', 'lessons_requests.user_id')
            ->update($data);

        $this->saveHistoryLog('lesson-request-given', $request);

        return (bool)$request;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $request = LessonsRequests::find($id);

        $this->saveHistoryLog('lesson-request-rejected', $request);

        return LessonsRequests::destroy($id);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getActiveUserRequests(int $userId): array
    {
        return LessonsRequests
            ::select('lesson', 'type', 'created_at', 'updated_at')
            ->where('user_id', '=', $userId)
            ->where('status', '=', 0)
            ->get()
            ->toArray();
    }

    /**
     * @param array $filter
     * @param array $geoRegions
     * @return array
     */
    public function getAll(array $filter, array $geoRegions): array
    {
        $query = $this->getAllLessonsQuery();
        $query->leftJoin('lft', 'lft.user_id', '=', 'p.user_id')
            ->select(
                DB::raw("CONCAT_WS(' ', p.last_name, p.first_name, p.middle_name) as userName"),
                "up.name_{$filter['lang']} as city",
                "up.country as country",
                'p.user_id as userId',
                'p.spiritual_name as spiritual_name',
                'p.phone',
                'lessons_requests.lesson',
                'lessons_requests.id',
                'lessons_requests.type',
                'lessons_requests.status',
                'lessons_requests.meditation_hours',
                'lessons_requests.created_at',
                'lessons_requests.updated_at',
                'u.lft as lftStatus',
                'p.image as userImage',
                'u.notes as notes',
                'p.telegram_id'
            );



        $count = $this->applyFilter($query, $filter, $geoRegions)->count();

        $data = $this->applyFilter($query, $filter, $geoRegions)
            ->orderBy($filter['orderBy'] ?? 'p.last_name', $filter['orderType'] ?? 'asc')
            ->skip($filter['skip'] ?? 0)
            ->take($filter['take'] ?? 50)
            ->get();


        $array = LessonRequestsResource::collection($data);


        /*$arrayCount = count($array);
        $removed = 0;
        for($i = 0; $i < $arrayCount-1; $i++) {
            if( $array[$i]['id'] === $array[$i+1]['id'] ) {
                unset($array[$i]);
                $removed++;
            }
        }*/

        return $data = [
            'requests' => $array,
            'total' => $count
        ];
    }

    /**
     * @param array $filter
     * @param array $geoRegions
     * @return int
     */
    public function getCount(array $filter, array $geoRegions): int
    {
        $query = $this->getAllLessonsQuery();
        return $this->applyFilter($query, $filter, $geoRegions)->count();
    }

    /**
     * @return Builder
     */
    private function getAllLessonsQuery(): Builder
    {
        return LessonsRequests::query()
            ->join('user_profiles as p', 'p.user_id', '=', 'lessons_requests.user_id')
            ->join('users as u', 'u.id', '=', 'lessons_requests.user_id')
            ->leftJoin('user_places as up', 'up.id', '=', 'p.place_id')
            ->leftJoin('meditation_lessons as ml', 'ml.user_id', '=', 'lessons_requests.user_id');
    }

    /**
     * @param Builder $query
     * @param array $filter
     * @param array $geoRegions
     * @return Builder
     */
    private function applyFilter(Builder $query, array $filter, array $geoRegions): Builder
    {
        $conditions = $this;
        $userId = $filter['userId'];
        $query->where(static function ($query) use ($conditions, $geoRegions, $userId) {
            /** @var $query \Illuminate\Database\Query\Builder */
            $query->orWhere(static function ($query) use ($conditions, $geoRegions, $userId) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->whereIn('lessons_requests.id', static function ($query) use ($conditions, $geoRegions) {
                    $query = $conditions->addGeoRegionJoins($query, $geoRegions);
                    $conditions->addGeoRegionConditions($query, $geoRegions);
                });
                $query->where(static function ($query) use ($userId) {
                    /** @var $query \Illuminate\Database\Query\Builder */
                    $query
                        ->orWhereNull('ml.id')
                        ->orWhere(static function ($query) use ($userId) {
                            /** @var $query Builder */
                            $query
                                ->where('ml.lesson_number', '=', 1);
                            //->where('ml.from_user_id', '=', $userId);
                        });
                });
            });

            $query->orWhereIn('lessons_requests.id', static function ($query) use ($conditions, $userId) {
                $conditions->filterByDelegatedLessons($query, $userId);
            });

            $query->orWhereNull('u.district_area_id');

            $query->orWhereNull('p.place_id');
        });

        if (isset($filter['sex'])) {
            $query->where('p.sex', '=', $filter['sex']);
        }

        if (isset($filter['lesson'])) {
            if((int)$filter['lesson'] !== 7) {
                $query->where('lessons_requests.lesson', '=', (int)$filter['lesson']);
            } else {
                $query->where('lessons_requests.lesson', '>', 1);
            }
        }

        if (isset($filter['status'])) {
            $query->where('lessons_requests.status', '=', (int)$filter['status']);
        }

        if (isset($filter['time'])) {
            $query->where('lessons_requests.meditation_hours', '=', (int)$filter['time']);
        }

        if (!empty($filter['type'])) {
            $query->where('lessons_requests.type', '=', $filter['type']);
        }

        if (!empty($filter['userName'])) {
            $userName = $filter['userName'];
            $query->whereRaw(DB::raw("CONCAT_WS(' ', p.last_name, p.first_name, p.middle_name) LIKE '%{$userName}%'"));
        }

        if (isset($filter['phone'])) {
            $query->where('p.phone', 'like', "%{$filter['phone']}%");
        }

        if (!empty($filter['city'])) {
            $query->where("up.name_{$filter['lang']}", 'like', "{$filter['city']}%");
        }

        if (!empty($filter['country'])) {
            $query->where("up.country", 'like', "{$filter['country']}%");
        }

        if (isset($filter['sortBy'])) {
            switch ($filter['sortBy']) {
                default:
                    $query->orderBy('created_at', $filter['sortOrder'] ?? 'desc');
            }
        }

        if(isset($filter['id'])) {
            $query->where('lessons_requests.id', $filter['id']);
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array $geoRegions
     * @return \Illuminate\Database\Query\Builder
     */
    private function addGeoRegionJoins(
        \Illuminate\Database\Query\Builder $query,
        array $geoRegions
    ): \Illuminate\Database\Query\Builder {
        $query
            ->select('lr.id')
            ->from('lessons_requests as  lr')
            ->join('users as u', 'u.id', '=', 'lr.user_id')
            ->join('district_areas as da', 'da.id', '=', 'u.district_area_id');

        $type = array_key_first($geoRegions);
        if ($type === GeolocationService::SECTOR) {
            $query
                ->join('districts as dis', 'dis.id', '=', 'da.district_id')
                ->join('dioceses as dio', 'dio.id', '=', 'dis.diocese_id')
                ->join('regions as r', 'r.id', '=', 'dio.region_id')
                ->join('sectors as s', 's.id', '=', 'r.sector_id');

            return $query;
        }

        if ($type === GeolocationService::REGION) {
            $query
                ->join('districts as dis', 'dis.id', '=', 'da.district_id')
                ->join('dioceses as dio', 'dio.id', '=', 'dis.diocese_id')
                ->join('regions as r', 'r.id', '=', 'dio.region_id');

            return $query;
        }

        if ($type === GeolocationService::DIOCESE) {
            $query
                ->join('districts as dis', 'dis.id', '=', 'da.district_id')
                ->join('dioceses as dio', 'dio.id', '=', 'dis.diocese_id');

            return $query;
        }

        if ($type === GeolocationService::DISTRICT) {
            $query->join('districts as dis', 'dis.id', '=', 'da.district_id');

            return $query;
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Query\Builder
     */
    private function filterByDelegatedLessons(
        \Illuminate\Database\Query\Builder $query,
        int $userId
    ): \Illuminate\Database\Query\Builder {
        return $query
            ->select('dl.lesson_request_id as id')
            ->from('delegated_lessons as dl')
            ->where('dl.user_id', '=', $userId);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array $geoRegions
     * @return \Illuminate\Database\Query\Builder
     */
    private function addGeoRegionConditions(
        \Illuminate\Database\Query\Builder $query,
        array $geoRegions
    ): \Illuminate\Database\Query\Builder {

        $query->where(static function ($q) use ($geoRegions) {
            /** @var  $q Builder */
            foreach ($geoRegions as $type => $geoRegion) {
                if ($type === GeolocationService::SECTOR) {
                    $q->orWhereIn('s.id', $geoRegion);
                    continue;
                }

                if ($type === GeolocationService::REGION) {
                    $q->orWhereIn('r.id', $geoRegion);
                    continue;
                }

                if ($type === GeolocationService::DIOCESE) {
                    $q->orWhereIn('dio.id', $geoRegion);
                    continue;
                }

                if ($type === GeolocationService::DISTRICT) {
                    $q->orWhereIn('dis.id', $geoRegion);
                    continue;
                }

                if ($type === GeolocationService::DISTRICT_AREA) {
                    $q->orWhereIn('da.id', $geoRegion);
                    continue;
                }
            }
        });

        return $query;
    }
}
