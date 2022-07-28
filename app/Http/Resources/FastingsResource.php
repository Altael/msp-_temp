<?php

namespace App\Http\Resources;

use App\Repositories\Handbooks\FastingsRepository;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FastingsResource extends JsonResource
{

    public function toArray($request)
    {
        $repository = new FastingsRepository();

        return [
            'id' => $this->id,
            'type' => $this->type,
            'date' => $this->date,
            'is_nearest' => in_array($this->date, $repository->getNearest())
        ];
    }
}
