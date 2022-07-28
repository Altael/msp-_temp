<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeditationLessonsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'lesson_number' => $this->lesson_number,
            'receiving_date' => $this->receiving_date,
            'teacher' => [
                'id' => $this->teacher ? $this->teacher->id : null,
                'name' => $this->teacher ? $this->teacher->displayName : __('Not in system')
            ],
            'foreign_teacher' => $this->acarya_missing,
            'manual' => $this->manual,
            'date_indicated' => $this->date_indicated
        ];

        return $data;
    }
}
