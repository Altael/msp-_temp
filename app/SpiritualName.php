<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class SpiritualName extends BaseModel
{
    protected $fillable = [
        'id',
        'sanskrit',
        'en',
        'ru'
    ];
}
