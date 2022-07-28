<?php

namespace App\Events;

class LessonWasGiven
{
    public $userId;
    public $lessonNumber;

    public function __construct($userId, $lessonNumber)
    {
        $this->userId = $userId;
        $this->lessonNumber = $lessonNumber;
    }

}
