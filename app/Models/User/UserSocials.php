<?php

namespace App\Models\User;

use App\Models\BaseModel;

class UserSocials extends BaseModel
{
    protected $fillable = ['user_id', 'social_id', 'provider'];
}
