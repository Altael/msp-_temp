<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BhuktiPradhanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'name' => optional($this->profile)->displayName ?? null,
            'rank' => $this->pivot->rank
        ];
    }
}
