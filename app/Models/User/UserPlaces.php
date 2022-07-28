<?php

namespace App\Models\User;

use App\Models\BaseModel;

class UserPlaces extends BaseModel
{
    protected $fillable = ['id', 'name_en', 'name_ru'];

    protected $appends = ['name'];

    //protected $primaryKey = 'created_at';

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"name_{$locale}"};
    }

    public function getRawIdAttribute()
    {
        return $this->attributes['id'];
    }
}
