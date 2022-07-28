<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description'
    ];

    protected $casts = [
        'name' => 'json',
        'description' => 'json'
    ];
}
