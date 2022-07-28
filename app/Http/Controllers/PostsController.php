<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\PostsEditResource;
use App\Http\Resources\PostsResource;
use App\Models\Blog\Like;
use App\Models\Blog\Post;
use App\Repositories\Blog\PostsRepository;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index(PostsRepository $repository, $category)
    {
        $data = $repository->getAllByCategory($category);

        if(request('subs')) {
            return [
                'subs' => $data['subs']
            ];
        }
        foreach($data['posts'] as $key => $post) {
            $data['posts'][$key]['likes'] = $post->likes()->count();
            $data['posts'][$key]['liked'] = $post->likes()->where('users.id', auth()->user()->id)->exists();
            $data['posts'][$key]['comments'] = $post->comments()->count();
        }

        $posts = PostsResource::collection($data['posts']);

        $total = $data['total'];

        return [
            'parent' => $data['parent'],
            'posts' => $posts,
            'total' => $total,
            'subs' => $data['subs'],
            'locale' => app()->getLocale(),
            'name' => $data['name']
        ];
    }

    public function list(PostsRepository $repository)
    {
        $data = $repository->getAll(request('skip', 0), request('take', 10));

        return [
            'posts' => PostsEditResource::collection($data['posts']),
            'total' => $data['total']
        ];
    }

    public function store()
    {
        $item = request('post');

        $post = Post::where('id', $item['id']);
        $post->update($item);

        return [
            'status' => 'ok'
        ];
    }

    public function show(PostsRepository $repository, $slug) {
        $post = new PostResource($repository->getPost($slug));

        return [
            'post' => $post
        ];
    }

    public function like($post_id) {
        $like = Like::firstOrCreate([
            'user_id' => auth()->user()->id,
            'post_id' => $post_id
        ]);

        if($like->wasRecentlyCreated) {
            return [
                'status' => 'liked'
            ];
        } else {
            $like->delete();
            return [
                'status' => 'unliked'
            ];
        }
    }
}
