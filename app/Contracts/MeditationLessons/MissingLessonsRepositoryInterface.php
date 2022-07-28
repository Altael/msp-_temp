<?php

namespace App\Contracts\MeditationLessons;

interface MissingLessonsRepositoryInterface
{
    public function getUserMissingLesson(int $userId);
}
