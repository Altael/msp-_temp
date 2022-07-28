<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryEvent extends Model
{
    protected $fillable = ['user_id', 'action_id', 'item_id', 'old', 'new'];

    protected $casts = [
        'old' => 'json',
        'new' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class, 'user_id');
    }

    public function action()
    {
        return $this->belongsTo(HistoryEventAction::class, 'action_id');
    }
}
