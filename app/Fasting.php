<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Fasting extends BaseModel
{
    protected $fillable = [
        'id',
        'type',
        'date'
    ];
}
