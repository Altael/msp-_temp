<?php

namespace App\Models\Blog;

use App\Models\AuditModel;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends AuditModel
{
    protected $table = 'blog_etc_post_categories';

    protected $fillable = [
        'blog_etc_post_id',
        'blog_etc_category_id'
    ];
}
