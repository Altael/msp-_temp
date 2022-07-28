<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Dharmacakra extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'points'
    ];

    protected $table = 'dharmacakra_practice';
}
