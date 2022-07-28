<?php

namespace App\Models\MeditationLessons;

use App\Models\BaseModel;

class DelegatedLessons extends BaseModel
{
    protected $fillable = ['user_id', 'lesson_request_id'];
}
