<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'path' => $this->path,
            'type' => $this->type,
            'source' => $this->source
        ];
    }
}
