<?php

namespace App\Models\Geolocation;

use App\Models\BaseModel;
use App\Models\User\User;

class Diocese extends BaseModel
{
    protected $fillable = ['region_id', 'name', 'notes'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function acaryas()
    {
        return $this->belongsToMany(User::class, 'acarya_geo', 'geo_id', 'acarya_id')->withPivotValue('type', 'diocese');
    }

    public function curators()
    {
        return $this->belongsToMany(User::class, 'curator_diocese', 'diocese_id', 'user_id');
    }

    public function getTelegramUsersWithRoles($roles)
    {
        $allUsers = collect([]);

        $districts = $this->districts;

        foreach ($districts as $district) {
            $users = $district->getTelegramUsersWithRoles($roles);
            $allUsers = $allUsers->merge($users);
        }

        return $allUsers;
    }
}
