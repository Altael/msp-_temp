<?php

namespace App\Contracts\MeditationLessons;

interface LessonsRequestsRepositoryInterface
{
    public function getById(int $id): array;

    public function save(array $data): bool;

    public function getActiveUserRequests(int $userId): array;

    public function getAll(array $filter, array $geoRegions): array;

    public function getCount(array $filter, array $geoRegions): int;

    public function update(int $id, array $data): bool;

    public function delete(int $id): int;
}
