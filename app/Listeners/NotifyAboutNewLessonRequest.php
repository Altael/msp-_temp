<?php

namespace App\Listeners;

use App\Events\NewLessonRequestAdded;
use App\Events\NewQuestionMessageAdded;
use App\Models\Questions\Questions;
use App\Models\User\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyAboutNewLessonRequest
{
    public function __construct()
    {
        //
    }

    public function handle(NewLessonRequestAdded $event)
    {
        $map = [
            'get' => __('lesson'),
            'check' => __('check')
        ];

        $user = User::findOrFail($event->data['user_id']);
        $lesson = $event->data['lesson'];
        $type = $event->data['type'];
        $teacher = $user->teacher;
        $page = request()->root();

        $city = optional(optional($user->profile)->place)->name;

        $message = "New {$lesson} {$map[$type]} request received from {$user->displayName} of {$city}
{$page}/requests?id={$event->data['id']}";

        if ($teacher && $teacher->profile && $teacher->profile->telegram_id) {
            Telegram::sendMessage([
                'chat_id' => $teacher->profile->telegram_id,
                'parse_mode' => 'html',
                'text' => strip_tags($message)
            ]);
        }
    }
}
