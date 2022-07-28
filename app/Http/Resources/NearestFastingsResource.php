<?php

namespace App\Http\Resources;

use App\Repositories\Handbooks\FastingsRepository;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NearestFastingsResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'type' => $this->type,
            'date' => $this->date
        ];
    }
}
