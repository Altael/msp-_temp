<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class InitiationsResource extends JsonResource
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
            'access' => $this->access,
            'avatar' => $this->avatar,
            'avgDiary' => $this->avgDiary,
            'city' => $this->city,
            'english' => $this->english,
            'lesson_number' => $this->lesson_number,
            'lftStatus' => $this->lftStatus,
            'notes' => $this->notes,
            'phone' => $this->phone,
            'prev_lessons' => $this->prev_lessons,
            'profession' => $this->profession,
            'receiving_date' => $this->receiving_date,
            'roles' => $this->roles,
            'spiritual_name' => $this->spiritual_name,
            'userId' => $this->userId,
            'userName' => $this->userName,
            'vk_id' => optional(optional($user->socials())->first())->provider === 'vkontakte' ? optional($user->socials())->first()->social_id : null
        ];
    }
}
