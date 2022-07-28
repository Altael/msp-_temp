<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyPracticeRanksDisplayResource extends JsonResource
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
            'name' => $this[app()->getLocale()],
            'points' => $this->points,
            'percent' => $this->percent,
            'guna' => $this->guna
        ];
    }
}
