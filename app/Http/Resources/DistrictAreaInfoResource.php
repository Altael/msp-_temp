<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictAreaInfoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            $this->id => $this->name
        ];
    }
}
