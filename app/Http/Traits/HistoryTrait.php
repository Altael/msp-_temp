<?php

namespace App\Http\Traits;

use App\HistoryEvent;
use App\HistoryEventAction;

trait HistoryTrait
{
    public function saveHistoryLog($action = null, $new = null, $old = null)
    {
        if(!$action) $action = request('action');
        if(!$old) $old = request('old') ?? null;
        if(!$new) $new = request('new') ?? null;

        $user_id = auth()->user()->id;
        $action_id = HistoryEventAction::where('slug', $action)->first()->id;
        $item_id = $new ? json_decode($new)->id : null;

        if(!$user_id || !$action_id) {
            return [
                'status' => 'That\'s not how it works, pal'
            ];
        }

        return HistoryEvent::create([
            'user_id' => $user_id,
            'action_id' => $action_id,
            'item_id' => $item_id,
            'old' => $old,
            'new' => $new
        ]);
    }
}
