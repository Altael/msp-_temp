<?php

namespace App\Http\Resources;

use App\Call;
use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CallRequestsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $call = Call::find($this->call_id);
        $user = User::find($this->user_id);

        return [
            'id' => $this->id,
            'date' => $this->date,
            'user_phone' => $this->user_phone,
            'user_messenger' => $this->user_messenger,
            'description' => $this->description,
            'closed' => $this->closed,
            'closed_status' => $this->closed_status,
            'closed_date' => $this->closed_date,
            'closed_notes' => $this->closed_notes,

            'user' => [
                'name' => $user->display_name,
                'avatar' => optional($user->profile)->image,
                'sex' => optional($user->profile)->sex,
                'city' => optional(optional($user->profile)->place)->name,
                'country' => optional(optional($user->profile)->place)->country
            ],
            'call_type' => new CallsResource($call),
            'host_id' => $this->host_id,
            'host' => $this->host_id ? User::find($this->host_id)->display_name : null,
            'guests_ids' => $this->guests_ids,
            'closed_user' => $this->closed_id ? User::find($this->closed_id)->display_name : null
        ];
    }
}
