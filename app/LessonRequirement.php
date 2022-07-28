<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LessonRequirement extends BaseModel
{
    protected $fillable = [
        'acarya_id',
        'lesson',
        'ru',
        'en'
    ];
}
