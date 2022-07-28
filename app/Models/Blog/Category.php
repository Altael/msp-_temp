<?php

namespace App\Models\Blog;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    protected $table = 'blog_etc_categories';

    protected $fillable = [
        'category_name',
        'slug',
        'category_description',
        'created_by',
        'parent_id',
        'author_avatar',
        'author_name_en',
        'author_name_ru'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'blog_etc_post_categories', 'blog_etc_category_id', 'blog_etc_post_id');
    }

    public function subs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function getAuthorNameAttribute()
    {
        return $this['author_name_' . app()->getLocale()];
    }
}
