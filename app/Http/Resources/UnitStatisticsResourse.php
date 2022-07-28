<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitStatisticsResourse extends JsonResource
{
    public function toArray($request)
    {
        $ini = 0;
        $not_ini = 0;

        foreach ($this->users as $user) {
            if($user->lessons->first()) {
                $ini++;
            } else {
                $not_ini++;
            }
        }

        return [
            'unit' => $this->unit->name,
            'date' => $this->date,
            'program' => $this->program->name,
            'initiated_members' => $ini,
            'not_initiated_members' => $not_ini,
            'initiated_guests' => $this->initiated_guests,
            'not_initiated_guests' => $this->not_initiated_guests
        ];
    }
}
