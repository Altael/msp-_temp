<?php

namespace App\Http\Controllers\Geolocation;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitTitlesResource;
use App\Http\Resources\UnitUserResource;
use App\Http\Resources\UserIdDisplayNameResource;
use App\Models\Geolocation\Unit;
use App\UnitTitle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnitUsersController extends Controller
{
    public function index()
    {
        $unit = Unit::findOrFail(request('unitId'));

        $titles = UnitTitle::all();

        $owned_titles = array_column(array_column($unit->users()->wherePivotNotNull('title_id')->get()->toArray(), 'pivot'), 'title_id');

        $free_titles = UnitTitle::whereNotIn('id', $owned_titles)->get();

        $users = $unit->users();

        if($name = request('name')) {
            $users->whereHas('profile', function ($q) use ($name) {
                $q->where('first_name', 'like', "%{$name}%")
                    ->orWhere('last_name', 'like', "%{$name}%")
                    ->orWhere('spiritual_name', 'like', "%{$name}%")
                    ->orWhere('unit_alias', 'like', "%{$name}%");
            });
        }


        $acaryas = UserIdDisplayNameResource::collection($unit->global_acaryas());

        return UnitUserResource::collection($users->orderBy('unit_user.title_id', 'desc')->get())->additional(
            [
                'since_creation' => Carbon::now()->diffInMinutes(Carbon::parse($unit->created_at)),
                'titles' => UnitTitlesResource::collection($free_titles),
                'acaryas' => array_pluck($acaryas->resolve(), 'name'),
                'status' => $unit->registration_status
            ]
        );
    }
}
