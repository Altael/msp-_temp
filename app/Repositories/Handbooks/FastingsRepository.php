<?php

namespace App\Repositories\Handbooks;

use App\Contracts\Handbooks\FastingsRepositoryInterface;
use App\Fasting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FastingsRepository implements FastingsRepositoryInterface
{
    public function getAll($skip = 0, $take = 10, $infinite = false)
    {
        $date = Carbon::today();

        $times = auth()->user()->profile->fasting;

        $prevFasting = Fasting::query()->latest('date')->whereDate('date', '<', $date)->take($times - 1);

        $fwFasting = Fasting::query()->whereDate('date', '>=', $date);

        if($times === 2) {
            $prevFasting = $prevFasting->where('type', 'ekadashi');
            $fwFasting = $fwFasting->where('type', 'ekadashi');
        }

        $fastings = $prevFasting->union($fwFasting);

        $this->applyUserFilters($fastings);

        $fastings = $infinite ? $fastings->get() : $fastings->skip($skip)->take($take)->get();

        return $fastings;
    }

    public function getCount()
    {
        return Fasting::all()->count();
    }

    public function getNearest()
    {
        $date = Carbon::today();

        $fastings[0] = Fasting::oldest('date')->whereDate('date', '>=', $date)->where('type', 'ekadashi')->first()->date;
        $fastings[1] = Fasting::oldest('date')->whereDate('date', '>=', $date)->whereIn('type', ['amavasya', 'purnima'])->first()->date;


        return $fastings;
    }

    public function getNearestSolo()
    {
        $date = Carbon::today();

        if(request()->exists('widget') && auth()->user()->profile->fasting === 2) {
            $fasting = Fasting::oldest('date')->whereDate('date', '>=', $date)->where('type', 'ekadashi')->first();
        } else {
            $fasting = Fasting::oldest('date')->whereDate('date', '>=', $date)->first();
        }



        return $fasting;
    }

    protected function applyUserFilters(&$fastings)
    {
        if ($type = request('type')) {
            $fastings->where('type', $type);
        }

        switch (request('sortBy')) {
            case 'type':
                $fastings->orderBy('type', request('sortOrder', 'desc'));
                break;
            default:
                $fastings->orderBy('date', request('sortOrder', 'asc'));
        }
    }
}
