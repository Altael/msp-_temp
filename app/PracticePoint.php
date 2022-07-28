<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PracticePoint extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'points',
        'time',
        'fee'
    ];
}
