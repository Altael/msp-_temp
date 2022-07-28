<?php

namespace App\Models\Geolocation;

use App\Models\BaseModel;
use App\Models\User\User;

class Sector extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'notes'
    ];

    /**
     * @param string $name
     * @return Sector
     */
    public function setName(string $name): Sector
    {
        $this->name = $name;
        return $this;
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function acaryas()
    {
        return $this->belongsToMany(User::class, 'acarya_geo', 'geo_id', 'acarya_id')->withPivotValue('type', 'sector');
    }

    public function getTelegramUsersWithRoles($roles)
    {
        $allUsers = collect([]);

        $regions = $this->regions;

        foreach ($regions as $region) {
            $users = $region->getTelegramUsersWithRoles($roles);
            $allUsers = $allUsers->merge($users);
        }

        return $allUsers;
    }
}
