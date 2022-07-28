<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryEventAction extends Model
{
    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'name' => 'json'
    ];
}
