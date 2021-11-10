<?php

namespace App\Services;

use App\Models\Comment;
use App\Services\ServiceExceptions\CommentCantDeleteException;
use Illuminate\Support\Facades\Auth;

class CommentService
{

    public function delete(int $id)
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();
        if (!$comment->canDelete($user))
        {
            throw new CommentCantDeleteException('Only admin and owner (within one hour) can delete comment.');
        }
        $comment->delete();

    }
}
