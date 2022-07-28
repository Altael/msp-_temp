<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitTitle extends Model
{
    protected $fillable = [
        'name_en',
        'name_ru',
        'name_uk',
        'slug'
    ];

}
