<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'image' => $this->image_large,
            'is_published' => $this->is_published,
            'body' => $this->post_body,
            'posted_at' => $this->posted_at,
            'subtitle' => $this->subtitle,
            'title' => $this->title,
            'category' => $this->categories()->first()->slug,
            'video' => $this->video
        ];
    }
}
