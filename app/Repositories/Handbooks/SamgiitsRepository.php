<?php

namespace App\Repositories\Handbooks;

use App\Contracts\Handbooks\FastingsRepositoryInterface;
use App\Samgit;

class SamgiitsRepository implements FastingsRepositoryInterface
{
    public function getAll($skip = 0, $take = 10)
    {
        $samgiits = Samgit::query();

        $this->applyUserFilters($samgiits);

        $samgiits = $samgiits->skip($skip)->take($take)->with('media')->get();

        return $samgiits;
    }

    public function getCount()
    {
        $samgiits = Samgit::query();

        $this->applyUserFilters($samgiits);

        return $samgiits->count();
    }

    protected function applyUserFilters(&$samgiits)
    {
        if ($transcription_en = request('transcription_en')) {
            $samgiits->where('transcription_en', 'like', "%{$transcription_en}%");
        }

        if ($translation_en = request('translation_en')) {
            $samgiits->where('translation_en', 'like', "%{$translation_en}%");
        }

        if ($daymonth = request('daymonth')) {
            $samgiits->where('daymonth', 'like', "%{$daymonth}%");
        }

        if ($title_en = request('title_en')) {
            $samgiits->where('title_en', 'like', "%{$title_en}%");
        }

        if ($title_ru = request('title_ru')) {
            $samgiits->where('title_ru', 'like', "%{$title_ru}%");
        }

        if ($title_uk = request('title_uk')) {
            $samgiits->where('title_uk', 'like', "%{$title_uk}%");
        }

        if ($transcription_ru = request('transcription_ru')) {
            $samgiits->where('transcription_ru', 'like', "%{$transcription_ru}%");
        }

        if ($translation_ru = request('translation_ru')) {
            $samgiits->where('translation_ru', 'like', "%{$translation_ru}%");
        }

        if ($translation_uk = request('translation_uk')) {
            $samgiits->where('translation_uk', 'like', "%{$translation_uk}%");
        }

        if ($transcription_uk = request('transcription_uk')) {
            $samgiits->where('transcription_uk', 'like', "%{$transcription_uk}%");
        }

        if ($samgiita_number = request('samgiita_number')) {
            $samgiits->where('samgiita_number', '=', $samgiita_number);
        }

        if ($samgiita_date = request('samgiita_date')) {
            $samgiits->where('samgiita_date', 'like', "%{$samgiita_date}%");
        }

        if ($samgiita_title = request('samgiita_title')) {
            $samgiits->where('samgiita_title', 'like', "%{$samgiita_title}%");
        }

        if ($samgiita_theme = request('samgiita_theme')) {
            $samgiits->where('samgiita_theme', 'like', "%{$samgiita_theme}%");
        }

        if ($samgiita_lyrics = request('samgiita_lyrics')) {
            $samgiits->where('samgiita_lyrics', 'like', "%{$samgiita_lyrics}%");
        }

        if ($samgiita_music = request('samgiita_music')) {
            $samgiits->where('samgiita_music', 'like', "%{$samgiita_music}%");
        }

        if ($sarkarverse_number = request('sarkarverse_number')) {
            $samgiits->where('sarkarverse_number', 'like', "%{$sarkarverse_number}%");
        }

        if ($sarkarverse_date = request('sarkarverse_date')) {
            $samgiits->where('sarkarverse_date', 'like', "%{$sarkarverse_date}%");
        }

        if ($sarkarverse_title = request('sarkarverse_title')) {
            $samgiits->where('sarkarverse_title', 'like', "%{$sarkarverse_title}%");
        }

        if ($sarkarverse_theme = request('sarkarverse_theme')) {
            $samgiits->where('sarkarverse_theme', 'like', "%{$sarkarverse_theme}%");
        }

        if ($sarkarverse_lyrics = request('sarkarverse_lyrics')) {
            $samgiits->where('sarkarverse_lyrics', 'like', "%{$sarkarverse_lyrics}%");
        }

        if ($sarkarverse_music = request('sarkarverse_music')) {
            $samgiits->where('sarkarverse_music', 'like', "%{$sarkarverse_music}%");
        }

        if ($premium = request('premium')) {
            $samgiits->where('premium', '=', true);
        }

        switch (request('sortBy')) {
            /*case 'type':
                $samgiits->orderBy('type', request('sortOrder', 'desc'));
                break;*/
            default:
                $samgiits->orderBy('id', request('sortOrder', 'asc'));
        }
    }
}
