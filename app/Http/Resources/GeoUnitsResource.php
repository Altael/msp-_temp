<?php

namespace App\Http\Resources;

use App\Models\Geolocation\Unit;
use Illuminate\Http\Resources\Json\JsonResource;
use jeremykenedy\LaravelRoles\Models\Role;
use function React\Promise\map;

class GeoUnitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $unit = Unit::find($this->id);

        if($secretary = optional($unit->secretary())->profile) {
            $secretary = [
                'image' => $secretary->image,
                'unit_alias' => $secretary->unit_alias,
                'telegram_nickname' => $secretary->telegram_nickname,
                'name' => $secretary->user->display_name
            ];
        } else {
            $secretary = null;
        }

        $officers = UnitOfficersResource::collection($unit->officers());



        $area = $unit->districtArea;
        $district = $area->district;
        $diocese = $district->diocese;
        $region = $diocese->region;
        $sector = $region->sector;

        return [
            'members_count' => $unit->users()->count(),
            'secretary' => $secretary,
            'officers' => $officers,
            'sector' => [
                'id' => $sector->id,
                'name' => $sector->name
            ],
            'region' => [
                'id' => $region->id,
                'name' => $region->name
            ],
            'diocese' => [
                'id' => $diocese->id,
                'name' => $diocese->name
            ],
            'district' => [
                'id' => $district->id,
                'name' => $district->name
            ],
            'area' => [
                'id' => $area->id,
                'name' => $area->name
            ],
            'unit' => [
                'id' => $unit->id,
                'name' => $unit->name
            ],
            'registration_status' => $this->registration_status
        ];
    }
}
