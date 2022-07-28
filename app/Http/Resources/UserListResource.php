<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{

    public function toArray($request)
    {
        $user = auth()->user();

        $vk_id = false;

        foreach($this->socials as $social) {
            if($social->provider === 'vkontakte') $vk_id = $social->social_id;
        }

        $this->roles->map( function ($role) {
            $role->sex = $this->profile ? $this->profile->sex : 'male';
        });

        $data = [
            'id' => $this->id,
            'email' => optional($this->profile)->email,
            'profession' => $this->profile ? $this->profile->profession : '',
            'lesson_number' => optional($this->currentLesson)->lesson_number,
            'avatar' => $this->profile ? $this->profile->image : null,
            'name' => $this->profile ? $this->profile->name : $this->name,
            'city' => optional(optional($this->profile)->place)->name,
            'country' => optional(optional($this->profile)->place)->country,
            'phone' => optional($this->profile)->phone,
            'districtArea' => optional($this->districtArea)->name,
            'spiritualName' => optional($this->profile)->spiritual_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'system_acarya' => optional(optional($this->teacher)->profile)->displayName,
            'system_acarya_avatar' => $this->teacher ? $this->teacher->profile->image : '',
            'has_profile' => $this->registration_completed || $this->fake ? true : false,
            'units' => $this->districtArea ? $this->districtArea->units : [],
            'initiation_date' =>  $this->lessons->where('lesson_number', 1)->first() ? $this->lessons->where('lesson_number', 1)->first()->receiving_date : null,
            'vk_id' => $vk_id,
            'phone_system' => $this->profile ? $this->profile->phone_system : null,
            'email_system' => $this->profile ? $this->profile->email_system : null,
            'telegram_system' => $this->profile ? $this->profile->telegram_system : null,
            'unit' => new UserListUnitResource($this->unit),
            'title' => $this->title,
            'roles' => UserEditRolesResource::collection($this->roles),
            'hide_from_unit' => $this->profile ? $this->profile->hide_from_unit : false,
            'unit_alias' => $this->profile ? $this->profile->unit_alias : '',
            'status' => new UsersStatusesResource($this->status),
            'dioceses' => GeoEditResource::collection($this->dioceses),
            'fake' => $this->fake
        ];

        if ($user->hasRole('admin|dean')) {
            $data += [
                'sector' => optional(optional(optional(optional(optional($this->districtArea)->district)->diocese)->region)->sector)->name,
                'region' => optional(optional(optional(optional($this->districtArea)->district)->diocese)->region)->name,
                'diocese' => optional(optional(optional($this->districtArea)->district)->diocese)->name,
                'district' => optional(optional($this->districtArea)->district)->name
            ];
        }

        if($user->hasRole('bp|admin|dean')) {
            $data += [
                'telegram' => $this->profile ? $this->profile->telegram_id ? true : false : null,
                'telegram_nickname' => $this->profile ? $this->profile->telegram_nickname : null,
            ];
        }

        if($user->hasRole('acarya')) {
            if(optional($this->profile)->acarya_diary && optional($this->teacher)->id === $user->id) {
                $data += [
                    'avgDiary' => optional($this->profile)->averageDiary
                ];
            }
        }

        return $data;
    }
}
