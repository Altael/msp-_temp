<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PracticeRank extends BaseModel
{
    protected $fillable = [
        'id',
        'en',
        'ru',
        'percent',
        'guna'
    ];
}
