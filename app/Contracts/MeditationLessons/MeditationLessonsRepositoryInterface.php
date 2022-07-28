<?php

namespace App\Contracts\MeditationLessons;

interface MeditationLessonsRepositoryInterface
{
    public function save(array $data): bool;

    public function getLastUserLesson(string $userId): int;

    public function getUserLessons(string $userId);

    public function delete(int $userId, int $lessonNumber): int;

    public function getFromUserLastLessons(string $fromUserId, array $filter = []);

    public function getCount(string $fromUserId, array $filter = []): int;
}
