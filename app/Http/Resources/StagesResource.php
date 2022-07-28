<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StagesResource extends JsonResource
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
            'course_id' => $this->course_id,
            'default_language' => $this->default_language,
            'description' => $this->description[app()->getLocale()] ?? $this->description[$this->default_language],
            'name' => $this->name[app()->getLocale()] ?? $this->name[$this->default_language],
            'finish_type' => $this->finish_type,
            'order' => $this->order,
            'published' => $this->published,
            'slug' => $this->slug,
            'videos' => $this->videos
        ];
    }
}
