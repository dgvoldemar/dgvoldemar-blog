<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LogicException;

class CommentService
{
    public function __construct(private Request $request)
    {}

    public function delete(int $id)
    {
        $comment = Comment::findOrFail($id);
        $user = $this->request->user();
        if (!$comment->canDelete($user))
        {
            throw new LogicException('Can not delete comment');
        }
        $comment->delete();

    }
}
