<?php

namespace App\Http\Resources;

use App\Call;
use Illuminate\Http\Resources\Json\JsonResource;

class CallRequestsDisplayResource extends JsonResource
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
            'slug' => Call::find($this->call_id)->slug,
            'closaed' => $this->closed,
            'date' => $this->date
        ];
    }
}
