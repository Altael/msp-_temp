<?php

namespace App\Models\MeditationLessons;

use App\Models\BaseModel;
use App\Models\User\User;

class MeditationLessons extends BaseModel
{
    protected $fillable = ['user_id', 'from_user_id', 'lesson_number', 'receiving_date', 'manual', 'date_indicated'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
