<?php

namespace App\Listeners;

use App\Events\UserAddedToUnit;
use App\Models\Geolocation\Unit;
use App\Models\User\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyUserAboutHisUnit
{
    public function handle(UserAddedToUnit $event)
    {
        /*$user = User::findOrFail($event->userId);
        $unit = Unit::findOrFail($event->unitId);
        $page = request()->root();

        if(!$user->profile || !$user->profile->telegram_id) return ['status' => 'no telegram'];

        $message = "You've been listed as member of unit \"{$unit->name}\".

{$unit['welcome_teleg_' . $user->language]}

You can see main information about your unit on page:
{$page}/unit";

        Telegram::sendMessage([
            'chat_id' => $user->profile->telegram_id,
            'parse_mode' => 'html',
            'text' => strip_tags($message)
        ]);*/
    }
}
