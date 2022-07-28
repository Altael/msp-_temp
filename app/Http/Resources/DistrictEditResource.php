<?php

namespace App\Http\Resources;

use App\Models\Geolocation\District;
use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictEditResource extends JsonResource
{

    public function toArray($request)
    {
        $district = District::find($this->id);
        $diocese = $district->diocese;
        $region = $diocese->region;
        $sector = $region->sector;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'bp' => $this->bp() ? new UserIdDisplayNameResource($this->bp()) : ['id' => null, 'name' => __('Choose option')],
            'bps' => count($this->bps) ? BhuktiPradhanResource::collection($this->bps) : [['id' => null, 'name' => __('Choose option')]],
            'notes' => $this->notes,
            'acaryas' => UserIdDisplayNameResource::collection($this->acaryas),
            'curator_acarya' => new UserIdDisplayNameResource($this->curator_acarya),
            'country' => $this->country ? $this->country[app()->getLocale()] ?? $this->country['en'] : null,
            'units' => $this->units->count(),
            'units_registration' => [
                'of_reg' => $this->units->where('registration_status', 'of_reg')->count(),
                'not_reg' => $this->units->where('registration_status', 'not_reg')->count(),
                'um' => $this->units->where('registration_status', 'um')->count()
            ],
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
            ]
        ];
    }
}
