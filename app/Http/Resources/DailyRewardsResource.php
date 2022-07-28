<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyRewardsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'en' => $this->en,
            'ru' => $this->ru,
            'author_en' => $this->author_en,
            'author_ru' => $this->author_ru,
            'type' => $this->type,
            'date_place' => $this->date_place,
            'default' => $this->default,
            'uk' => $this->uk,
            'author_uk' => $this->author_uk,
            'title_uk' => $this->title_uk,
            'title_ru' => $this->title_ru,
            'title_en' => $this->title_en,
            'source_uk' => $this->source_uk,
            'source_en' => $this->source_en,
            'source_ru' => $this->source_ru,
            'audio_author_uk' => $this->audio_author_uk,
            'audio_author_en' => $this->audio_author_en,
            'audio_author_ru' => $this->audio_author_ru,
            'place_uk' => $this->place_uk,
            'place_ru' => $this->place_ru,
            'place_en' => $this->place_en,
            'record_date_uk' => $this->record_date_uk,
            'record_date_ru' => $this->record_date_ru,
            'record_date_en' => $this->record_date_en,
            'audio_ru' => $this->audio_ru,
            'audio_en' => $this->audio_en,
            'audio_uk' => $this->audio_uk,
            'media' => $this->media,
            'original_comentary_lang' => $this->original_comentary_lang,
            'en_comentary_seju_en' => $this->en_comentary_seju_en,
            'en_comentary_seju_ru' => $this->en_comentary_seju_ru,
            'en_comentary_seju_uk' => $this->en_comentary_seju_uk,
            'ru_comentary_seju_en' => $this->ru_comentary_seju_en,
            'ru_comentary_seju_ru' => $this->ru_comentary_seju_ru,
            'ru_comentary_seju_uk' => $this->ru_comentary_seju_uk,
            'uk_comentary_seju_en' => $this->uk_comentary_seju_en,
            'uk_comentary_seju_ru' => $this->uk_comentary_seju_ru,
            'uk_comentary_seju_uk' => $this->uk_comentary_seju_uk
        ];
    }
}
