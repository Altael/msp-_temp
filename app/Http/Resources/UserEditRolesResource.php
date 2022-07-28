<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditRolesResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->slug === 'sadhaka' ? $this->sex === 'female' ? __('Sadhika') : __('Sadhaka') : __($this->name),
            'slug' => $this->slug,
        ];
    }
}
