<?php

namespace App\Repositories\Handbooks;

use App\Contracts\Handbooks\SpiritualNamesRepositoryInterface;
use App\SpiritualName;
use Illuminate\Support\Facades\DB;

class SpiritualNamesRepository implements SpiritualNamesRepositoryInterface
{
    public function getAll($skip = 0, $take = 10)
    {
        $names = SpiritualName::query();

        $this->applyUserFilters($names);

        $names = $names->skip($skip)->take($take)->get();

        return $names;
    }

    public function getAllForUser()
    {
         return SpiritualName::where('status', 1)->get();
    }

    public function getCount()
    {
        return SpiritualName::all()->count();
    }

    protected function applyUserFilters(&$names)
    {
        //$names->selectRaw('users.*');

        if ($name_ru = request('ru')) {
            $names->where('ru', 'like', "%$name_ru%");
        }

        if ($name_en = request('en')) {
            $names->where('en', 'like', "%$name_en%");
        }

        if ($sex = request('sex')) {
            $names->where('sex', $sex);
        }

        switch (request('sortBy')) {
            case 'ru':
                $names->orderBy('ru', request('sortOrder', 'desc'));
                break;
            case 'en':
                $names->orderBy('en', request('sortOrder', 'desc'));
                break;
            default:
                $names->orderBy('sex', request('sortOrder', 'desc'));
        }
    }
}
