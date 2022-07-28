<?php

namespace App\Http\Controllers;

use App\HistoryEvent;
use App\HistoryEventAction;
use App\Http\Traits\HistoryTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    use HistoryTrait;

    public function showEvents($type = null, $start = null, $end = null, $unique = false)
    {
        $type = $type ?? (request('type') ?? null);
        $start = $start ?? (request('start') ?? null);
        $end = $end ?? (request('end') ?? null);
        $unique = (bool)request('unique');

        if(!$type) return [
            'status' => 'there is no response'
        ];

        $event = HistoryEventAction::where('slug', $type)->first();

        $events = HistoryEvent::where('action_id', $event->id)->whereDate('created_at', '>=', $start ?? '01.01.1990')->whereDate('created_at', '<=', $end ?? '31.12.3000');

        if($unique) {
            $events->groupBy('user_id');
        }

        return [
            'events' => $events->pluck('created_at'),
            'name' => $event->name[app()->getLocale()]
        ];
    }
}
