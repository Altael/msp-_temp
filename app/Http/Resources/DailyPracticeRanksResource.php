<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyPracticeRanksResource extends JsonResource
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
            'id' => $this->id,
            'ru' => $this->ru,
            'en' => $this->en,
            'points' => $this->points,
            'percent' => $this->percent,
            'guna' => $this->guna
        ];
    }
}
