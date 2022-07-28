<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallRequest extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'user_phone',
        'user_messenger',
        'call_id',
        'host_id',
        'guest_ids',
        'description',
        'closed',
        'closed_status',
        'closed_date',
        'closed_id',
        'closed_notes'
    ];

    protected $casts = [
        'date' => 'datetime',
        'guest_ids' => 'array',
        'closed_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class, 'user_id');
    }
}
