<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'body' => $this->post_body,
            'image_large' => $this->image_large,
            'posted_at' => $this->posted_at,
            'short_description' => $this->short_description,
            'likes' => $this->likes,
            'liked' => $this->liked,
            'comments' => $this->comments,
            'author_avatar' => $this->author_avatar,
            'author_name_ru' => $this->author_name_ru,
            'author_name_en' => $this->author_name_en,
            'author' => $this['author_name_' . app()->getLocale()],
            'audio' => $this->audio,
            'video' => $this->video
        ];
    }
}
