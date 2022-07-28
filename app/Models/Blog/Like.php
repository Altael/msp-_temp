<?php

namespace App\Models\Blog;

use App\Models\AuditModel;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Like extends AuditModel
{
    protected $table = 'blog_etc_user_likes';

    protected $fillable = ['user_id', 'post_id'];
}
