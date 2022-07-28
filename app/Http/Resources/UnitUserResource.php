<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitUserResource extends JsonResource
{

    public function toArray($request)
    {
        $this->roles->map( function ($role) {
            $role->sex = $this->profile ? $this->profile->sex : 'male';
        });

        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'spiritual_name' => $this->profile ? $this->profile->spiritual_name : '',
            'unit_alias' => $this->profile ? $this->profile->unit_alias : '',
            'social_name' => $this->profile ? "{$this->profile->first_name} {$this->profile->last_name}": '',
            'phone' => $this->profile ? $this->profile->phone : '',
            'email' => optional($this->profile)->email,
            'telegram' => $this->profile ? ($this->profile->telegram_id ? true : false) : false,
            'telegram_nickname' => $this->profile ? $this->profile->telegram_nickname : null,
            'roles' => UserEditRolesResource::collection($this->roles),
            'title' => $this->unit ? $this->title : null,
            'status' => new UsersStatusesResource($this->status),
            'phone_system' => $this->profile ? $this->profile->phone_system : null,
            'email_system' => $this->profile ? $this->profile->email_system : null,
            'telegram_system' => $this->profile ? $this->profile->telegram_system : null,
            'notes' => $this->notes,
            'hide_from_unit' => $this->profile ? $this->profile->hide_from_unit : false
        ];
    }
}
