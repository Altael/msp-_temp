<?php

namespace App\Models\User;

use App\Models\AuditModel;
use App\Models\BaseModel;

class UserTeachers extends AuditModel
{
    protected $table = 'users_teachers';

    protected $fillable = ['user_id', 'teacher_user_id'];
}
