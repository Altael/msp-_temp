<?php

namespace App\Models\Geolocation;

use App\Models\BaseModel;
use App\Models\User\User;

class District extends BaseModel
{
    protected $fillable = [
        'diocese_id', 'name', 'bp_id', 'notes', 'country', 'curator_acarya_id'
    ];

    protected $casts = [
        'country' => 'array'
    ];

    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'diocese_id');
    }

    public function districtAreas()
    {
        return $this->hasMany(DistrictArea::class);
    }

    public function units()
    {
        return $this->hasManyThrough(Unit::class, DistrictArea::class);
    }

    public function bp()
    {
        return $this->belongsToMany(User::class, 'district_user', 'district_id', 'user_id')->withPivotValue('rank', 'BP')->first();
    }

    public function bps()
    {
        return $this->belongsToMany(User::class, 'district_user', 'district_id', 'user_id')->withPivot('rank');
    }

    public function acaryas()
    {
        return $this->belongsToMany(User::class, 'acarya_geo', 'geo_id', 'acarya_id')->withPivotValue('type', 'district');
    }

    public function curator_acarya()
    {
        return $this->hasOne(User::class, 'id', 'curator_acarya_id');
    }

    public function global_acaryas()
    {
        $district_acaryas = $this->acaryas;
        $diocese_acaryas = $this->diocese->acaryas;
        $region_acaryas = $this->diocese->region->acaryas;
        $sector_acaryas = $this->diocese->region->sector->acaryas;

        return $district_acaryas->merge($diocese_acaryas)->merge($region_acaryas)->merge($sector_acaryas);
    }

    public function getTelegramUsersWithRoles($roles)
    {
        $allUsers = collect([]);

        $areas = $this->districtAreas;

        foreach ($areas as $area) {
            $users = $area->getTelegramUsersWithRoles($roles);
            $allUsers = $allUsers->merge($users);
        }

        return $allUsers;
    }
}
