<?php

namespace App\Listeners;

use App\Events\SpiritualNameChanged;
use App\Models\User\User;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyUserAboutSpiritualName
{

    public function handle(SpiritualNameChanged $event)
    {
        $user = User::findOrFail($event->userId);
        $spiritualName = $event->spiritualName;

        $user->update(['notify_name' => 1]);

        if($user && $user->profile && $user->profile->telegram_id) {
            $message = "Your spiritual name was changed to {$spiritualName}.";

            Telegram::sendMessage([
                'chat_id' => $user->profile->telegram_id,
                'parse_mode' => 'html',
                'text' => strip_tags($message)
            ]);
        }
    }
}
