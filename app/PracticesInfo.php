<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PracticesInfo extends BaseModel
{
    protected $fillable = [
        'slug',
        'help_en',
        'help_ru',
        'title_en',
        'title_ru'
    ];

    protected $table = 'practices_info';
}
