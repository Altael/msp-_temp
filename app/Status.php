<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name_ru',
        'name_en',
        'name_uk',
        'unit_id',
        'notes_ru',
        'notes_en',
        'notes_uk'
    ];
}
