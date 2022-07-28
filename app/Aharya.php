<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Aharya extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'points'
    ];

    protected $table = 'aharya_practice';
}
