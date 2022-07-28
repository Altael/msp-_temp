<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProgramsResource;
use App\Http\Resources\UnitMembersResource;
use App\Http\Resources\UnitProgramsResource;
use App\Program;
use App\Repositories\UnitProgramsRepository;
use App\UnitProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitProgramsController extends Controller
{
    public function index(UnitProgramsRepository $repository)
    {
        $response = $repository->getAll(request('unit_id', auth()->user()->unit->id), request('skip', 0), request('take', 10));
        $unit_programs = UnitProgramsResource::collection($response['programs']);
        $total = $response['total'];

        $programs_items = Program::all();
        $programs = [];
        foreach ($programs_items as $item) {
            $programs[$item->slug] = $item['name_' . app()->getLocale()];
        }
        $programs_items = ProgramsResource::collection(Program::orderByDesc('vip')->orderBy('order')->get());

        $unit_members = auth()->user()->units()->first()->users();

        if ($name = request('name')) {
            $unit_members->whereHas('profile', function ($query) use ($name) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$name%")
                    ->orWhere('spiritual_name', 'like', "%$name%")
                    ->orWhere('unit_alias', 'like', "%$name%");
            });
        }

        if($statuses = request('statuses')) {
            $unit_members->whereHas('statuses', function ($query) use ($statuses) {
                $query->whereIn('status_id', $statuses);
            });
        }

        $unit_members = UnitMembersResource::collection($unit_members->get());

        $main_unit = [
            'id' => auth()->user()->unit->id,
            'name' => auth()->user()->unit->name
        ];

        if(count(auth()->user()->bpDistricts)) {
            $bhuktis = implode(',', auth()->user()->bpDistricts->pluck('id')->toArray());

            $units = json_decode(json_encode(\DB::select("
            SELECT
u.id AS id,
                   u.name AS name

FROM districts dis

JOIN district_areas di ON dis.id = di.district_id
JOIN units u ON di.id = u.district_area_id

WHERE dis.id IN ({$bhuktis})")), true);
        } else {
            $units = [$main_unit];
        }

        return [
            'unit_programs' => $unit_programs,
            'total' => $total,
            'programs' => $programs,
            'programs_object' => $programs_items,
            'members' => $unit_members,
            'available_units' => $units,
            'main_unit' => $main_unit
        ];
    }

    public function store()
    {
        $item = request('unit_program');

        $unit_id = auth()->user()->units()->first()->id;

        $users_ids = \Arr::pluck($item['users'], 'id');

        if ($item['id'] !== null) {
            $unit_program = UnitProgram::where('id', $item['id'])->first();
            $unit_program->update([
                'unit_id' => $unit_id,
                'program_id' => $item['program']['id'],
                'date' => $item['date'],
                'initiated_guests' => $item['initiated_guests'],
                'not_initiated_guests' => $item['not_initiated_guests']
            ]);
        } else {
            $unit_program = UnitProgram::create([
                'unit_id' => $unit_id,
                'program_id' => $item['program']['id'],
                'date' => $item['date'],
                'initiated_guests' => $item['initiated_guests'],
                'not_initiated_guests' => $item['not_initiated_guests']
            ]);
        }

        $unit_program->users()->sync($users_ids);

        return [
            'status' => 'ok'
        ];
    }

    public function destroy($id)
    {
        UnitProgram::where('id', $id)->delete();

        return [
            'status' => 'ok'
        ];
    }
}
