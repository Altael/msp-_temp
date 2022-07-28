<?php

namespace App\Contracts\MeditationLessons;

interface MeditationLessonsServiceInterface
{
    /**
     * @param int $userId
     * @param int $lessonNumber
     * @param int $fromUserId
     * @param bool $manual
     * @return bool
     */
    public function saveUserLesson(int $userId, int $lessonNumber, int $fromUserId = 0, bool $manual = false): bool;

    /**
     * @param int $userId
     * @return int
     */
    public function getLastUserLesson(int $userId): int;
}
