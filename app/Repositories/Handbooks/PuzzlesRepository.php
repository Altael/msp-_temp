<?php

namespace App\Repositories\Handbooks;

use App\Contracts\Handbooks\FastingsRepositoryInterface;
use App\DailyReward;
use App\Fasting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PuzzlesRepository implements FastingsRepositoryInterface
{
    public function getAll($skip = 0, $take = 10)
    {
        $puzzles = DailyReward::query();

        $this->applyUserFilters($puzzles);

        $puzzles = $puzzles->skip($skip)->take($take)->with('media')->get();

        return $puzzles;
    }

    public function getCount()
    {
        return DailyReward::all()->count();
    }

    protected function applyUserFilters(&$puzzles)
    {
        $puzzles->where('default', false);

        if ($type = request('type')) {
            $puzzles->where('type', $type);
        }

        switch (request('sortBy')) {
            case 'type':
                $puzzles->orderBy('type', request('sortOrder', 'desc'));
                break;
            default:
                $puzzles->orderBy('date', request('sortOrder', 'asc'));
        }
    }

    public function getDailyQuote()
    {
        srand(Carbon::now()->startOfDay()->timestamp);
        $ids = DailyReward::all()->pluck('id')->toArray();
        DailyReward::where('id', array_rand(array_flip($ids), 1))->first();

        $daily = DailyReward::where('id', array_rand(array_flip($ids), 1))->first();

        return $daily;
    }

    public function getSvadhyaya()
    {
        $daily = DailyReward::where('type', 'svadhyaya')->whereDate('date', Carbon::today()->startOfWeek()->subDays(-1 * 7 * request('index')))->first() ?? DailyReward::where('type', 'svadhyaya')->where('default', true)->first();

        return $daily;
    }

    public function getUserQuotes()
    {
        $worth_days = auth()->user()->dailyPractices()->where('points', '>=', 80)->pluck('date');

        $quotes = DailyReward::where('type', 'quote')->whereIn('date', $worth_days)->get();

        return $quotes;
    }

    public function getUserStories()
    {
        $worth_days = auth()->user()->dailyPractices()->where('points', '>=', 136)->pluck('date');

        $stories = DailyReward::where('type', 'story')->whereIn('date', $worth_days)->get();

        return $stories;
    }
}
