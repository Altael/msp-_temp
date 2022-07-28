<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyRewardDisplayResource extends JsonResource
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
            'text' => $this[app()->getLocale()],
            'title' => $this['title_' . app()->getLocale()],
            'source' => $this['source_' . app()->getLocale()],
            'author' => $this['author_' . app()->getLocale()],
            'place' => $this['place_' . app()->getLocale()],
            'record_date' => $this['record_date_' . app()->getLocale()],
            'audio_author' => $this['audio_author_' . app()->getLocale()],
            'date' => $this->date,
            'audio' => $this->audio,
            'audio_lang' => $this['audio_' . app()->getLocale()]
        ];
    }
}
