<?php

namespace App\Http\Controllers;

use App\Events\ViewPost;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->filter(
                request(['search', 'category', 'author'])
            )->paginate(18)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        $user = Auth::user();
        $visitor = Request::ip();
        ViewPost::dispatch($post, $visitor, $user);

        return view('posts.show', [
            'post' => $post
        ]);
    }
}
