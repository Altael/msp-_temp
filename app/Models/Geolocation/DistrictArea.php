<?php

namespace App\Models\Geolocation;

use App\Models\BaseModel;
use App\Models\User\User;

class DistrictArea extends BaseModel
{
    protected $fillable = ['district_id', 'name', 'place_id', 'type', 'notes', 'default_unit_id'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function default_unit()
    {
        return $this->hasOne(Unit::class, 'id', 'default_unit_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'district_area_id');
    }

    public function setDistrictId(int $value): DistrictArea
    {
        $this->district_id = $value;
        return $this;
    }

    public function setName(string $value): DistrictArea
    {
        $this->name = $value;
        return $this;
    }

    public function setPlaceId(string $value): DistrictArea
    {
        $this->place_id = $value;
        return $this;
    }

    public function setType(string $value): DistrictArea
    {
        $this->type = $value;
        return $this;
    }

    public function setDefaultUnitId(int $value): DistrictArea
    {
        $this->default_unit_id = $value;
        return $this;
    }

    public function acaryas()
    {
        return $this->belongsToMany(User::class, 'acarya_geo', 'geo_id', 'acarya_id')->withPivotValue('type', 'district_area');
    }

    public function getTelegramUsersWithRoles($roles)
    {
        $users = $this->users()->whereHas('profile', function ($query) {
            $query->whereNotNull('telegram_id');
        });

        $users->where(function ($query) use ($roles) {
            foreach ($roles as $role) {
                $query->orWhereHas('roles', function ($query) use ($role) {
                    $query->where('slug', $role);
                });
            }
        });

        return $users->get();
    }
}
