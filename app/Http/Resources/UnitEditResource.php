<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Http\Resources\UserIdDisplayNameResource;

class UnitEditResource extends JsonResource
{

    public function toArray($request)
    {
        $unit = [
            'id' => $this->id,
            'name' => $this->name,
            'registration_status' => $this->registration_status,
            'curator_acarya' => optional($this->district->curator_acarya)->displayName
        ];

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('bp')) {
            $secretaries = [];
            foreach ($this->users as $member) {
                if($member->hasRole('secretary')) $secretaries[] = new UserIdDisplayNameResource($member);
            }

            $unit += [
                'secretary' => $this->secretary(),
                'notes' => $this->notes,
                'acaryas' => UserIdDisplayNameResource::collection($this->acaryas),
                'users' => UnitUserResource::collection($this->users),
                'secretaries' => $secretaries
            ];
        }

        return $unit;
    }
}
