<?php

namespace App\Console\Commands;

use App\Models\User\UserProfile;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class FindUsersTelegramNickname extends Command
{

    protected $signature = 'users:find-telegram-nickname {--full}';
    protected $description = 'Find telegram nicknames of users';

    public function handle()
    {
        $users = UserProfile::whereNotNull('telegram_id');

        if(!$this->option('full')) {
            $users->whereNull('telegram_nickname');
        }

        $users = $users->get();

        foreach($users as $user) {
            try{
                $user_info = Telegram::getChat([
                    'chat_id' => $user->telegram_id
                ]);

                $user->update([
                    'telegram_nickname' => $user_info['username'] ?? null
                ]);
            } catch(\Exception $e) {
                print_r($user->display_name . " отключил(-а) телеграм или произошла еще какая то малопонятная херота. \n");
            }
        }

        return 0;
    }
}
