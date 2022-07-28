<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserToolsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $vk_id = false;

        foreach($this->socials as $social) {
            if($social->provider === 'vkontakte') $vk_id = $social->social_id;
        }

        $this->roles->map( function ($role) {
            $role->sex = $this->profile ? $this->profile->sex : 'male';
        });

        return [
            'id' => $this->id,
            'image' => $this->profile ? $this->profile->image : null,
            'unit_alias' => $this->profile ? $this->profile->unit_alias : null,
            'telegram_nickname' => $this->profile ? $this->profile->telegram_nickname : null,
            'name' => $this->display_name,
            'title' => $this->title,
            'telegram' => $this->profile ? $this->profile->telegram_id : null,
            'roles' => UserEditRolesResource::collection($this->roles),
            'phone' => $this->profile ? $this->profile->phone_system ? $this->profile->phone_system : $this->profile->phone : null,
            'email' => $this->profile ? $this->profile->email_system ? $this->profile->email_system : $this->profile->email : null,
            'vk_id' => $vk_id
        ];
    }
}
