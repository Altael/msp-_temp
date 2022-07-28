<?php

namespace App\Models\Blog;

use App\Models\BaseModel;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Post extends BaseModel
{
    protected $table = 'blog_etc_posts';

    protected $fillable = [
        'id',
        'slug',
        'user_id',
        'title',
        'subtitle',
        'meta_desc',
        'post_body',
        'use_view_file',
        'posted_at',
        'is_published',
        'image_large',
        'image_medium',
        'image_thumbnail',
        'short_description',
        'seo_title',
        'lang',
        'audio',
        'video'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_etc_post_categories', 'blog_etc_post_id', 'blog_etc_category_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'blog_etc_user_likes', 'post_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_etc_post_id');
    }
}
