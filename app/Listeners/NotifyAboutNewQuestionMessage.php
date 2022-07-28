<?php

namespace App\Listeners;

use App\Events\NewQuestionMessageAdded;
use App\Models\Questions\Questions;
use App\Models\User\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyAboutNewQuestionMessage
{
    public function __construct()
    {
        //
    }

    public function handle(NewQuestionMessageAdded $event)
    {

        $question = Questions::findOrFail($event->data['question_id']);

        $from = User::findOrFail($question->from_user_id);
        $to = User::findOrFail($question->to_user_id);

        $user = $event->data['user_id'] === $from->id ? $to : $from;
        $author = $event->data['user_id'] === $from->id ? $from : $to;


        $conversation = $event->data['is_acarya'] ? 'conversations' : 'user/conversations';
        $dialogue_id = $event->data['question_id'];

        $link = 'https://personal.meditationsteps.org/' . $conversation . '?dialogue=' . $dialogue_id;

        $message = "New message from {$author->profile->displayName}:<pre>\n</pre> {$link} <pre>\n\n</pre><b>{$question->subject}</b><pre>\n</pre>{$event->data['text']}";

        if ($user->profile && $user->profile->telegram_id) {
            Telegram::sendMessage([
                'chat_id' => $user->profile->telegram_id,
                'parse_mode' => 'html',
                'text' => $message
            ]);
        }
    }
}
