<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamgitsMspMedia extends Model
{
    protected $table = "samgits_media";

    protected $fillable = [
        'samgit_id',
        'media_id'
    ];


}
