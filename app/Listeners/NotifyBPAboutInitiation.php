<?php

namespace App\Listeners;

use App\Events\LessonWasGiven;
use App\Models\User\User;
use Telegram\Bot\Laravel\Facades\Telegram;


class NotifyBPAboutInitiation
{

    public function handle(LessonWasGiven $event)
    {
        $user = User::findOrFail($event->userId);
        $lessonNumber = $event->lessonNumber;
        $page = request()->root();

        if ($lessonNumber === 1) {
            $bp = null;
            if($user && $user->districtArea && $user->districtArea->district && $user->districtArea->district->bps) {
                $bps = $user->districtArea->district->bps;
            }

            foreach($bps as $bp) {
                if ($bp && $bp->profile && $bp->profile->telegram_id) {

                    $message = "Initiation was given for user in your bhukti: {$user->profile->displayName}
{$page}/users?user={$user->profile->hash_id}";

                    Telegram::sendMessage([
                        'chat_id' => $bp->profile->telegram_id,
                        'parse_mode' => 'html',
                        'text' => strip_tags($message)
                    ]);

                }
            }
        }
    }
}
