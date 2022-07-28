<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryEditResource;
use App\Models\Blog\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return [
            'categories' => CategoryEditResource::collection(Category::all())
        ];
    }

    public function store()
    {
        $item = request('category');

        $category = Category::where('id', $item['id']);
        $category->update([
            'author_avatar' => $item['author_avatar'],
            'author_name_en' => $item['author_name_en'],
            'author_name_ru' => $item['author_name_ru'],
            'parent_id' => $item['parent'] ? $item['parent']['id'] : null,
        ]);

        return [
            'status' => 'ok'
        ];
    }
}
