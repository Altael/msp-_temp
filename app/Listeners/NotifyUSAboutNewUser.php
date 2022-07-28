<?php

namespace App\Listeners;

use App\Events\UserAddedToUnit;
use App\Models\Geolocation\Unit;
use App\Models\User\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyUSAboutNewUser
{
    public function handle(UserAddedToUnit $event)
    {
        $user = User::findOrFail($event->userId);
        $unit = Unit::findOrFail($event->unitId);
        $page = request()->root();

        if(!$unit || !$unit->secretary() || !$unit->secretary()->profile || !$unit->secretary()->profile->telegram_id) return ['status' => 'no secretary'];

        $message = "New sadhaka was added to your unit: {$user->profile->displayName}
{$page}/users?user={$user->profile->hash_id}";

        Telegram::sendMessage([
            'chat_id' => $unit->secretary()->profile->telegram_id,
            'parse_mode' => 'html',
            'text' => strip_tags($message)
        ]);
    }
}
