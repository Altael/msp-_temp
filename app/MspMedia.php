<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MspMedia extends Model
{
    protected $table = "msp_media";

    protected $fillable = [
        'path',
        'type',
        'source'
    ];
}
