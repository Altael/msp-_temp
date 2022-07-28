<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonRequestsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::find($this->userId);

        return [
            'city' => $this->city,
            'created_at' => $this->created_at,
            'id' => $this->id,
            'lesson' => $this->lesson,
            'lftStatus' => $this->lftStatus,
            'meditation_hours' => $this->meditation_hours,
            'notes' => $this->notes,
            'phone' => $this->phone,
            'spiritual_name' => $this->spiritual_name,
            'status' => $this->status,
            'telegram_id' => $this->telegram_id,
            'type' => $this->type,
            'updated_at' => $this->updated_at,
            'userId' => $this->userId,
            'userImage' => $this->userImage,
            'userName' => $this->userName,
            'vk_id' => optional(optional($user->socials())->first())->provider === 'vkontakte' ? optional($user->socials())->first()->social_id : null
        ];
    }
}
