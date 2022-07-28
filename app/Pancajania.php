<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Pancajania extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'points'
    ];

    protected $table = 'pancajania_practice';
}
