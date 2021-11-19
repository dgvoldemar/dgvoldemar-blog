<?php

namespace App\Services;

use App\Models\Post;

class PostService
{

    public static function getTotalViews(Post $post) : int
    {
        return count($post->views);
    }

    public static function getTodayViews(Post $post) : int
    {
        return $post->views()->whereDate('created_at', \Carbon\Carbon::today())->count();
    }
}
