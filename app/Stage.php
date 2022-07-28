<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'slug',
        'course_id',
        'order',
        'name',
        'description',
        'videos',
        'content',
        'default_language',
        'published',
        'finish_type'
    ];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'videos' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User\User::class, 'stage_user', 'stage_id', 'user_id')->withPivot('finished');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
