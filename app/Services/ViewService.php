<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Request;

class ViewService
{
    public function view(Post $post, ?Authenticatable $user)
    {
        $visitor = Request::ip();

        if ($user) {
            $view = $post->views()->where('user_id', '=', $user->id)->first();
        } else {
            $view = $post->views()->where('visitor', '=', $visitor)->first();
        }

        if (!$view){
            $post->views()->create([
                'user_id' => $user->id ?? NULL,
                'visitor' => $visitor
            ]);
        }
    }
}
