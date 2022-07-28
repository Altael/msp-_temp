<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $action = $this->action;

        return [
            'name' => $this->action->name[app()->getLocale()] ?? $this->action->name['en'],
            'date' => $this->created_at
        ];
    }
}
