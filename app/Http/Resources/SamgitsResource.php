<?php

namespace App\Http\Resources;

use App\MspSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class SamgitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->user();

        $settings = $user->settings;

        $transcript_locale = request('tl') ?? $settings->dc_transcription_lang;
        $translate_locale = request('ml') ?? $settings->dc_main_lang;

        return [
            'transcription' => $this['transcription_' . $transcript_locale] ?? $this->transcription_en,
            'translation' => $this['translation_' . $translate_locale] ?? $this->translation_en,
            'title' => $this['title_' . $transcript_locale] ?? $this->title_en,
            'mp3' => MediaResource::collection($this->media()->where('type', 'audio')->get()),
            'favorite' => $user->samgits()->where('samgits.id', $this->id)->exists(),
            'id' => $this->id,
            'samgiita_number' => $this->samgiita_number,
            'samgiita_date' => $this->samgiita_date,
            'samgiita_title' => $this->samgiita_title,
            'samgiita_theme' => $this->samgiita_theme,
            'samgiita_lyrics' => $this->samgiita_lyrics,
            'samgiita_music' => $this->samgiita_music,
            'sarkarverse_number' => $this->sarkarverse_number,
            'sarkarverse_date' => $this->sarkarverse_date,
            'sarkarverse_title' => $this->sarkarverse_title,
            'sarkarverse_theme' => $this->sarkarverse_theme,
            'sarkarverse_lyrics' => $this->sarkarverse_lyrics,
            'sarkarverse_music' => $this->sarkarverse_music
        ];
    }
}
