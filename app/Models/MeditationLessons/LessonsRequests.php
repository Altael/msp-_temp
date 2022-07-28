<?php

namespace App\Models\MeditationLessons;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LessonsRequests extends BaseModel
{
    protected $fillable = ['user_id', 'lesson', 'type', 'status', 'meditation_hours', 'creation_date'];

    static public function types($value) {
        $values = [
            'get' => __('Get'),
            'check' => __('Check')
        ];

        return $values[$value] ?? $values;
    }
}
