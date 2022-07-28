<?php

namespace App\Repositories;

use App\Contracts\UnitProgramsRepositoryInterface;
use App\UnitProgram;
use Illuminate\Support\Facades\DB;

class UnitProgramsRepository implements UnitProgramsRepositoryInterface
{
    public function getAll($unit = 0, $skip = 0, $take = 10)
    {
        $programs = UnitProgram::where('unit_id', $unit);

        $this->applyUserFilters($programs);

        $count = $programs->count();

        $programs = $programs->skip($skip)->take($take)->get();

        return [
            'programs' => $programs,
            'total' => $count
        ];
    }

    protected function applyUserFilters(&$programs)
    {
        /*if ($program = request('program')) {
            $programs->where('type', $program);
        }*/



        switch (request('sortBy')) {
            case 'type':
                $programs->orderBy('type', request('sortOrder', 'desc'));
                break;
            default:
                $programs->orderBy('date', request('sortOrder', 'asc'));
        }
    }
}
