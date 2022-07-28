<?php

namespace App\Repositories\Blog;

use App\Contracts\Blog\PostsRepositoryInterface;
use App\Http\Resources\CategoryListResource;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostsRepository implements PostsRepositoryInterface
{
    public function getAllByCategory($category = "news")
    {
        $category = Category::where('slug', $category)->first();

        $subCategories = CategoryListResource::collection($category->subs()->get());

        $categories = [];

        $this->getSubsThroughTree($categories, $category);

        $posts_type = request('posts');

        $only_subs = request('subs');

        if($only_subs) {
            return [
                'subs' => $subCategories
            ];
        }

        if($posts_type === 'all') {
            $posts = Post::query()->join('blog_etc_post_categories as pc', 'blog_etc_posts.id', '=', 'pc.blog_etc_post_id')
                ->join('blog_etc_categories as c', 'pc.blog_etc_category_id', '=', 'c.id')
                ->whereIn('c.slug', $categories)
                ->latest('posted_at')
                ->where('is_published', 1)
                ->where('lang', app()->getLocale())
                ->select([
                    'blog_etc_posts.*',
                    'c.author_avatar',
                    'c.author_name_ru',
                    'c.author_name_en'
                ])
                ->get();
        } else {
            $posts = Post::query()->join('blog_etc_post_categories as pc', 'blog_etc_posts.id', '=', 'pc.blog_etc_post_id')
                ->join('blog_etc_categories as c', 'pc.blog_etc_category_id', '=', 'c.id')
                ->where('c.slug', $category->slug)
                ->oldest('posted_at')
                ->where('is_published', 1)
                ->where('lang', app()->getLocale())
                ->select([
                    'blog_etc_posts.*',
                    'c.author_avatar',
                    'c.author_name_ru',
                    'c.author_name_en'
                ])
                ->get();
        }

        $total = $posts->count();

        return [
            'parent' => $category->parent()->first() ? new CategoryListResource($category->parent()->first()) : null,
            'posts' => $posts,
            'total' => $total,
            'subs' => $subCategories,
            'name' => $category->category_name
        ];
    }

    public function getAll($skip = 0, $take = 10)
    {
        $posts = Post::query();

        $total = $posts->count();

        $posts = $posts->skip($skip)->take($take)->latest()->get();

        //$posts = $this->applyUserFilters($posts);

        return  [
            'posts' => $posts,
            'total' => $total
        ];
    }

    protected function applyUserFilters(&$posts)
    {
        if ($lang = request('lang')) {
            $posts->where('lang', $lang);
        }

        if ($title = request('title')) {
            $posts->where('title', 'like', $title);
        }

        switch (request('sortBy')) {
            /*case 'lang':
                $posts->orderBy('lang', request('sortOrder', 'desc'));
                break;*/
            default:
                $posts->orderBy('posted_at', request('sortOrder', 'asc'));
        }
    }

    public function getPost($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return $post;
    }

    public function getCategoryName($slug)
    {
        return Post::where('slug', $slug)->value('category_name');
    }

    protected function getSubsThroughTree(&$subCategories, $category)
    {
        $subCategories[] = $category->slug;

        $subs = $category->subs()->get();

        foreach($subs as $sub)
        {
            $this->getSubsThroughTree($subCategories, $sub);
        }
    }
}
