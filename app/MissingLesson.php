<?php

namespace App;

use App\Models\BaseModel;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class MissingLesson extends BaseModel
{
    protected $fillable = [
        'user_id',
        'lessons',
        'acarya_missing',
        'initiation_date',
        'status',
        'acarya_first',
        'acarya_changed',
        'acarya_now',
        'acarya_first_missing'
    ];


    protected $casts = [
        'lessons' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function first_acarya()
    {
        return $this->belongsTo(User::class, 'acarya_first');
    }

    public function current_acarya()
    {
        return $this->belongsTo(User::class, 'acarya_now');
    }
}
