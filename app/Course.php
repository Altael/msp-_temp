<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'slug',
        'author_ids',
        'name',
        'description',
        'required',
        'published',
        'default_language',
        'schedule',
        'mode',
        'order',
        'exam'
    ];

    protected $casts = [
        'author_ids' => 'array',
        'name' => 'json',
        'description' => 'json'
    ];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User\User::class, 'course_user', 'course_id', 'user_id')->withPivot('finished');
    }

    public function stages()
    {
        return $this->hasMany(Stage::class, 'course_id');
    }


}
