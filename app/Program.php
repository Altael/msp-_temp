<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Program extends BaseModel
{
    protected $fillable = [
        'slug',
        'name_ru',
        'name_en',
        'notes_ru',
        'notes_en',
        'vip',
        'order',
        'short_name_ru',
        'short_name_en'
    ];

    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }
}
