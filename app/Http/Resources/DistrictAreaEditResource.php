<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictAreaEditResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'place_id' => $this->place_id,
            'notes' => $this->notes,
            'acaryas' => UserIdDisplayNameResource::collection($this->acaryas),
            'unit' => $this->default_unit() ? new UnitEditResource($this->default_unit()->first()) : null,
            'units' => UnitEditResource::collection($this->units)
        ];
    }
}
