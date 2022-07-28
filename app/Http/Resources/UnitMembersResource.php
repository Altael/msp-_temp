<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitMembersResource extends JsonResource
{

    public function toArray($request)
    {
        if(auth()->user()->hasSuperRole()) {
            $name = $this->profile ? $this->profile->name: '';
        } else {
            $name = $this->profile ? $this->profile->privateName: '';
        }

        return [
            'id' => $this->id,
            'image' => $this->profile ? $this->profile->image : '',
            'name' => $name,
            'spiritual_name' => $this->profile ? $this->profile->spiritual_name : '',
            'is_margii' => !is_null($this->lessons->first()),
            'is_programmer' => $this->hasRole('programmer'),
            'unit_alias' => $this->profile ? $this->profile->unit_alias : '',
            'status' => $this->status,
            'image_system' => $this->profile ? $this->profile->image_system : null,
            'telegram_system' => $this->profile ? $this->profile->telegram_system : null,
            'email_system' => $this->profile ? $this->profile->email_system : null,
            'phone_system' => $this->profile ? $this->profile->phone_system : null,
            'fake' => $this->fake,
            'notes' => $this->notes,
            'hide_from_unit' => $this->profile ? $this->profile->hide_from_unit : false
        ];
    }
}
