<?php

namespace App\Models\User;

use App\Models\BaseModel;

class Lft extends BaseModel
{
    protected $table = 'lft';

    protected $fillable = ['user_id', 'status'];
}
