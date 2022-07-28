<?php

namespace App\Contracts\Blog;

interface PostsRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllByCategory();

    public function getAll();
}
