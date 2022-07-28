<?php

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected $name = "start";

    protected $description = "Start Command to get you started";

    public function handle()
    {
        $this->replyWithMessage(['text' => 'Добро пожаловать в чат-бот проекта "Урокимедитации". Тут вы будете получать актуальную информацию. Оставайтесь с нами']);
    }
}
