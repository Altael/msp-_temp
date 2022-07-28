<?php

namespace App\Repositories\MeditationLessons;

use App\Contracts\MeditationLessons\MeditationLessonsRepositoryInterface;
use App\Http\Resources\InitiationsResource;
use App\Http\Traits\HistoryTrait;
use App\Models\MeditationLessons\MeditationLessons;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MeditationLessonsRepository implements MeditationLessonsRepositoryInterface
{
    use HistoryTrait;

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        return (bool)MeditationLessons::create($data);
    }

    /**
     * @param string $userId
     * @return int
     */
    public function getLastUserLesson(string $userId): int
    {
        $lessons = MeditationLessons
            ::where('user_id', $userId)
            ->orderBy('lesson_number', 'ASC')
            ->pluck('lesson_number')->toArray();

        foreach($lessons as $index => $lesson) {
            if(($index !== count($lessons) - 1) && ($lesson !== $lessons[$index+1] - 1)) {
                return $lesson;
            }
        }

        return end($lessons);
    }

    /**
     * @param string $userId
     * @return int
     */
    public function getUserLessons(string $userId)
    {
        return MeditationLessons::where('meditation_lessons.user_id', $userId)->get();
    }

    /**
     * @param int $userId
     * @param int $lessonNumber
     * @return int
     */
    public function delete(int $userId, int $lessonNumber): int
    {
        $lesson = MeditationLessons
            ::where('user_id', $userId)
            ->where('lesson_number', $lessonNumber)->first();

        $this->saveHistoryLog('lesson-cancelled', $lesson);

        return $lesson->delete();
    }

    /**
     * @param string $fromUserId
     * @param array $filter
     * @return object
     */
    public function getFromUserLastLessons(string $fromUserId, array $filter = [])
    {
        $query = MeditationLessons::query()
            ->join('user_profiles as p', 'p.user_id', '=', 'meditation_lessons.user_id')
            ->join('user_places as up', 'up.id', '=', 'p.place_id')
            ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
            ->leftJoin('daily_practices as dp', 'dp.user_id', '=', 'p.user_id')
            ->select(
                DB::raw("CONCAT_WS(' ', p.last_name, p.first_name) as userName"),
                'p.user_id as userId',
                'p.image as avatar',
                "up.name_{$filter['lang']} as city",
                "up.country as country",
                'p.phone',
                'p.profession as profession',
                'p.spiritual_name',
                'p.english as english',
                'p.acarya_diary as access',
                'meditation_lessons.receiving_date',
                'u.notes as notes',
                DB::raw('AVG(dp.points) as avgDiary'),
                DB::raw('MAX(meditation_lessons.lesson_number) as lesson_number'),
                'u.lft as lftStatus'
            )
            ->where('from_user_id', $fromUserId);

        $data = InitiationsResource::collection($this->applyFilter($query, $filter)
            ->groupBy('meditation_lessons.user_id')
            ->orderBy($filter['orderBy'] ?? 'p.last_name', $filter['orderType'] ?? 'asc')
            ->skip($filter['skip'] ?? 0)
            ->take($filter['take'] ?? 10)
            ->get());

        return $data;
    }



    /**
     * @param string $fromUserId
     * @param array $filter
     * @return int
     */
    public function getCount(string $fromUserId, array $filter = []): int
    {
        $query = MeditationLessons
            ::join('user_profiles as p', 'p.user_id', '=', 'meditation_lessons.user_id')
            ->join('user_places as up', 'up.id', '=', 'p.place_id')
            ->leftJoin('lft', 'lft.user_id', '=', 'p.user_id')
            ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
            ->select(DB::raw('COUNT(DISTINCT(meditation_lessons.user_id)) as total'))
            ->where('from_user_id', $fromUserId);

        $result = (int)$this->applyFilter($query, $filter)
            ->value('total');

        return $result;
    }

    /**
     * @param Builder $query
     * @param array $filter
     * @return Builder
     */
    private function applyFilter(Builder $query, array $filter): Builder
    {
        if (!empty($filter['lesson'])) {
            //$query->where('meditation_lessons.lesson_number', '=', (int)$filter['lesson']);
            $query->fromRaw("(select *, MAX(lesson_number) AS number from `meditation_lessons` GROUP BY user_id) AS meditation_lessons")
                ->where('meditation_lessons.number', $filter['lesson']);
        }

        if (!empty($filter['phone'])) {
            $query->where('p.phone', 'like', "%{$filter['phone']}%");
        }

        if (!empty($filter['profession'])) {
            $query->where('p.profession', 'like', "%{$filter['profession']}%");
        }

        if (!empty($filter['userName'])) {
            $query->where(function($query) use ($filter) {
                $query->where('p.first_name', 'like', "%{$filter['userName']}%")
                    ->orWhere('p.last_name', 'like', "%{$filter['userName']}%")
                    ->orWhere('p.spiritual_name', 'like', "%{$filter['userName']}%");
            });
        }

        if (!empty($filter['city'])) {
            $query->where("up.name_{$filter['lang']}", 'like', "%{$filter['city']}%");
        }

        if (!empty($filter['country'])) {
            $query->where("up.country", 'like', "%{$filter['country']}%");
        }

        switch($filter['sortBy']) {
            case 'name':
                $query->orderBy('p.first_name', $filter['sortOrder'])
                    ->orderBy('p.last_name', $filter['sortOrder']);
            break;
            case 'city':
                $query->orderBy("up.name_{$filter['lang']}", $filter['sortOrder']);
            break;
            case 'en':
                $query->orderBy('p.english', $filter['sortOrder']);
            break;
            case 'lft':
                $query->orderBy('lft.status', $filter['sortOrder']);
            break;
            default:
                $query->orderBy('receiving_date', $filter['sortOrder']);
        }

        return $query;
    }
}
