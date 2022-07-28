<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class EasterEggScore extends BaseModel
{
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'message'
    ];
}
