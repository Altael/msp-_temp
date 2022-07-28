<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteUsersSamgits extends Model
{
    protected $table = 'favorite_users_samgits';

    protected $fillable = ['user_id', 'samgit_id'];
}
