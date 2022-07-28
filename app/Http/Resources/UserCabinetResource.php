<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCabinetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(auth()->user() && auth()->user()->hasRole('admin')) {
            $name = $this->displayName;
        } else {
            $name = ($this->spiritual_name ? $this->spiritual_name . ' (' : '') . ($this->first_name ?? '') . ($this->last_name ?? '') . ($this->spiritual_name ? ')' : '');
        }

        return [
            'avatar' => $this->image,
            'name' => $name,
            'roles' => $this->user->roles->pluck('name'),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'spiritual_name' => $this->spiritual_name,
            'hash_id' => $this->hash_id
        ];
    }
}
