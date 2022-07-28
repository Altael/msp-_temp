<?php

namespace App\Http\Controllers;

use App\Models\User\UserProfile;
use Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $profile_id = $profile->hash_id;
        $telegram_id = $profile->telegram_id;

        return [
            'telegram_id' => $telegram_id,
            'profile_id' => $profile_id
        ];
    }

    public function disconnect()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $telegram_id = $profile->telegram_id;

        $profile->update([
            'telegram_id' => null,
            'telegram_nickname' => null
        ]);
    }

    public function bot()
    {
        $item = Telegram::getWebhookUpdates();

        \Log::debug(print_r($item, true));

        if ($message = $item->getMessage()) {
            $text = $message->getText();

            if (Str::start($text, '/start connect_user_')) {
                preg_match("/^\/start connect_user_(.+)$/", $text, $matches);

                if ($id = ($matches[1] ?? null)) {
                    \Log::debug("ID: {$id}");
                    if ($user = UserProfile::where('hash_id', $id)->first()) {
                        $user->update([
                            'telegram_id' => $message->getChat()->getId(),
                            'telegram_nickname' => $message->getChat()->getNickname() ?? null
                        ]);
                    }
                }
            }
        }

        $update = Telegram::commandsHandler(true);

        return [
            'status' => 'ok',
        ];
    }
}
