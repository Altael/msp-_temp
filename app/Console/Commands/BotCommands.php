<?php namespace App\Console\Commands;

use App\Models\User\User;
use App\Models\User\UserProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotCommands extends Command
{
    protected $signature = 'bot:commands';
    protected $description = 'Bot commands';

    public function handle()
    {
        $update = Telegram::commandsHandler();

        foreach ($update as $item) {
            if ($message = $item->getMessage()) {
                $text = $message->getText();

                if (Str::start($text, '/start connect_user_')) {
                    preg_match("/^\/start connect_user_(\d)$/", $text, $matches);

                    if ($id = ($matches[1] ?? null)) {
                        $user = UserProfile::where('hash_id', $id)->findOrFail();

                        $user->update([
                            'telegram_id' => $message->getChat()->getId(),
                            'telegram_nickname' => $message->getChat()->getNickname() ?? null
                        ]);
                    }
                }

                else {
                    //dd($item);
                }
            }
        }

        //dd($update);
    }
}
