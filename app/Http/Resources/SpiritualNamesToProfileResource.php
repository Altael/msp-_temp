<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpiritualNamesToProfileResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'en' => $this->en,
            'ru' => $this->ru,
            'sex' => $this->sex
        ];
    }
}
