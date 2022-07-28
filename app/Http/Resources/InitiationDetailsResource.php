<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InitiationDetailsResource extends JsonResource
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
            'created_at' => $this->created_at,
            'lesson_number' => $this->lesson_number,
            'teacher' => $this->teacher ? ($this->teacher->profile ? $this->teacher->profile->displayName : '') : ''
        ];
    }
}
