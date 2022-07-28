<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MantrasResource extends JsonResource
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

        /*dd(app()->getLocale());*/

        return [
            'transcription' => $this['transcription_' . $transcript_locale],
            'translation' => $this['text_' . $translate_locale],
            'title' => $this['title_' . app()->getLocale()],
            'mp3' => $this->mp3,
            'slug' => $this->slug
        ];
    }
}
