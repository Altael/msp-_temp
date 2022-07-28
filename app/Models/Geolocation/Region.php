<?php

namespace App\Models\Geolocation;

use App\Models\BaseModel;
use App\Models\User\User;

class Region extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sector_id', 'name', 'notes'];

    /**
     * @param string $name
     * @return Region
     */
    public function setName(string $name): Region
    {
        $this->name = $name;
        return $this;
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function dioceses()
    {
        return $this->hasMany(Diocese::class);
    }

    public function acaryas()
    {
        return $this->belongsToMany(User::class, 'acarya_geo', 'geo_id', 'acarya_id')->withPivotValue('type', 'region');
    }

    public function getTelegramUsersWithRoles($roles)
    {
        $allUsers = collect([]);

        $dioceses = $this->dioceses;

        foreach ($dioceses as $diocese) {
            $users = $diocese->getTelegramUsersWithRoles($roles);
            $allUsers = $allUsers->merge($users);
        }

        return $allUsers;
    }
}
