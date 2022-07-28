<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MspSetting extends Model
{
    protected $fillable = [
        'entity',
        'entity_id',
        'dc_transcription_lang',
        'dc_main_lang',
        'standard_samgiits_type',
        'standard_samgiits_amount',
        'standard_samgiits_list',
        'active_member_quota',
        'standard_statuses'
    ];

    protected $casts = [
        'standard_samgiits_list' => 'array',
        'standard_statuses' => 'array'
    ];
}
