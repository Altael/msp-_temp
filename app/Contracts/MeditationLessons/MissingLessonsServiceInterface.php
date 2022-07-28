<?php

namespace App\Contracts\MeditationLessons;

interface MissingLessonsServiceInterface
{
    public function getUserMissingLesson(int $userId);

}
