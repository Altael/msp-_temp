<?php

namespace App\Http\Resources;

use App\Models\User\User;
use App\Http\Resources\GeoEditResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
{

    public function toArray($request)
    {
        $this->roles->map( function ($role) {
            $role->sex = $this->profile ? $this->profile->sex : 'male';
        });

        return [
            'id' => $this->id,
            'name' => $this->displayName,
            'districtArea' => $this->districtArea()->with('district.diocese.region')->first(),
            'profile' => $this->profile,
            'full_roles' => UserEditRolesResource::collection($this->roles),
            'roles' => UserEditRolesResource::collection($this->roles()->whereIn('roles.id', auth()->user()->accessed_roles->pluck('id')->toArray())->get()),
            'acaryas' => UserIdDisplayNameResource::collection($this->acaryas),
            'notes' => $this->notes,
            'unit_alias' => $this->profile->unit_alias,
            'status' => $this->status,
            'phone_system' => $this->profile ? $this->profile->phone_system : null,
            'email_system' => $this->profile ? $this->profile->email_system : null,
            'telegram_system' => $this->profile ? $this->profile->telegram_system : null,
            'unit' => $this->unit,
            'dioceses' => GeoEditResource::collection($this->dioceses),
            'profession' => $this->profile ? $this->profile->profession : '',
            'lesson_number' => optional($this->currentLesson)->lesson_number,
            'city' => optional(optional($this->profile)->place)->name,
            'country' => optional(optional($this->profile)->place)->country,
            'system_acarya' => optional(optional($this->teacher)->profile)->displayName,
            'system_acarya_avatar' => $this->teacher ? $this->teacher->profile->image : '',
            'registration_date' => $this->created_at,
            'initiation_date' =>  $this->lessons->where('lesson_number', 1)->first() ? $this->lessons->where('lesson_number', 1)->first()->receiving_date : null,
            'title' => $this->title,
            'lft' => $this->lft
        ];
    }
}
