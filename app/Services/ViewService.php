<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Auth\Authenticatable;

class ViewService
{
    public function view(Post $post, string $visitor, ?Authenticatable $user)
    {
        if ($user) {
            $view = $post->views()->where('user_id', '=', $user->id)->exists();
        } else {
            $view = $post->views()->where('visitor', '=', $visitor)->exists();
        }

        if (!$view) {
            $post->views()->create([
                'user_id' => $user->id ?? NULL,
                'visitor' => $visitor
            ]);
        }
    }
}
