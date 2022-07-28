<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitProgramsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'program' => new ProgramsResource($this->program),
            'users' => UnitMembersResource::collection($this->users),
            'initiated_guests' => $this->initiated_guests,
            'not_initiated_guests' => $this->not_initiated_guests
        ];
    }
}
