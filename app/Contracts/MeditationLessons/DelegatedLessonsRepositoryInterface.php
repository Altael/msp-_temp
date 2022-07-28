<?php

namespace App\Contracts\MeditationLessons;

interface DelegatedLessonsRepositoryInterface
{
    public function save(array $data): bool;

    public function delete(int $id): int;
}
