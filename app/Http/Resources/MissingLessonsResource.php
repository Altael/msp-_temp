<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MissingLessonsResource extends JsonResource
{

    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'first_acarya' => $this->first_acarya ? optional($this->first_acarya->profile)->displayName : $this->acarya_first_missing,
            'name' => $this->user->profile->displayName,
            'lesson' => $this->lesson,
            'acarya_changed' => $this->acarya_changed,
            'current_acarya' =>  $this->current_acarya ? optional($this->current_acarya->profile)->displayName : $this->acarya_missing,
            'status' => $this->status,
            'initiation_date' => $this->initiation_date
        ];

        return $data;
    }
}
