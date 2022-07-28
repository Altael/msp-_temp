<?php

namespace App\Models\Blog;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class BlogPhoto extends BaseModel
{

    protected $table = 'blog_etc_uploaded_photos';

    protected $fillable = [
        'uploaded_images',
        'image_title',
        'source',
        'uploader_id'
    ];
}
