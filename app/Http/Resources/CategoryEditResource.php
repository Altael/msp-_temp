<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryEditResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->category_name,
            'slug' => $this->slug,
            'parent' => new CategoryListResource($this->parent),
            'author_avatar' => $this->author_avatar,
            'author_name_en' => $this->author_name_en,
            'author_name_ru' => $this->author_name_ru
        ];
    }
}
