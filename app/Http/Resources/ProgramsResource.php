<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this['name_' . app()->getLocale()],
            'short_name' => $this['short_name_' . app()->getLocale()],
            'vip' => $this->vip
        ];
    }
}
