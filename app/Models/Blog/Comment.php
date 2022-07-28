<?php

namespace App\Models\Blog;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Comment extends BaseModel
{
    protected $table = 'blog_etc_comments';

    protected $fillable = [
        'blog_etc_post_id',
        'user_id',
        'ip',
        'author_name',
        'comment',
        'approved',
        'author_email',
        'author_website'
    ];
}
