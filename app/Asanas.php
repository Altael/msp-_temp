<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Asanas extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'points'
    ];

    protected $table = 'asanas_practice';
}
