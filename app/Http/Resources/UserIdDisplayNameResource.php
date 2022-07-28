<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIdDisplayNameResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'name' => optional($this->profile)->displayName ?? null,
            'sex' => optional($this->profile)->sex ?? null
        ];
    }
}
