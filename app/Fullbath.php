<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Fullbath extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'points'
    ];

    protected $table = 'fullbath_practice';
}
