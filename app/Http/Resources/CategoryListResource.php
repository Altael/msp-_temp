<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->category_name,
            'slug' => $this->slug,
            'description' => $this->category_description,
            'author_name' => $this['author_name_' . app()->getLocale()]
        ];
    }
}
