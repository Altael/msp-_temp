<?php

namespace App\Repositories\MeditationLessons;

use App\Contracts\MeditationLessons\MeditationLessonsRepositoryInterface;
use App\Contracts\MeditationLessons\MissingLessonsRepositoryInterface;
use App\Events\NewLessonRequestAdded;
use App\MissingLesson;
use App\Models\MeditationLessons\LessonsRequests;
use App\Models\MeditationLessons\MeditationLessons;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class MissingLessonsRepository implements MissingLessonsRepositoryInterface
{
    public function getUserMissingLesson(int $userId)
    {
        return MissingLesson::where('user_id', $userId)
            ->where('status', 0)
            ->first();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        $status =  (bool)MissingLesson::create($data);

        //event(new NewMissingRequestAdded($data));

        return $status;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function update(int $id): bool
    {
        return (bool)MissingLesson
            ::where('Missing_lessons.id', $id)
            ->update(['status' => 1]);
    }

    public function getAll($skip = 0, $take = 10)
    {
        $requests = MissingLesson::query();

        $this->applyUserFilters($requests);

        $requests = $requests->skip($skip)->take($take)->get();

        return $requests;
    }

    public function getCount()
    {
        return MissingLesson::all()->count();
    }

    public function declineRequest(array $data)
    {
        return MissingLesson::destroy($data['id']);
    }

    protected function applyUserFilters(&$requests)
    {
        if ($name = request('name')) {
            $requests->whereHas('user', function ($query) use ($name) {
                $query->whereHas('profile', function ($query2) use ($name) {
                    $query2->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$name%")
                        ->orWhere('spiritual_name', 'like', "%$name%");
                });
            });
        }

        if ($lesson = request('lesson')) {
            $requests->where('lesson', $lesson);
        }



        switch (request('sortBy')) {
            case 'name':
                $requests->join('user_profiles', 'missing_lessons.user_id', '=', 'user_profiles.user_id')
                    ->orderBy('user_profiles.first_name', request('sortOrder', 'desc'))
                    ->orderBy('user_profiles.last_name', request('sortOrder', 'desc'))
                    ->select('missing_lessons.*');
            break;
            case 'lesson':
                $requests->orderBy('lesson', request('sortOrder', 'desc'));
            break;
            default:
                $requests->orderBy('receiving_date', request('sortOrder', 'desc'));
        }

    }
}
