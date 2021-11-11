<?php

namespace App\Services;

use App\Models\Comment;
use App\Services\ServiceExceptions\CommentCantDeleteException;
use Illuminate\Support\Facades\Auth;

class CommentService
{

    public function delete(int $id, $user)
    {
        $comment = Comment::findOrFail($id);
        if (!$comment->canDelete($user))
        {
            throw new CommentCantDeleteException('Only admin and owner (within one hour) can delete comment.');
        }
        $comment->delete();

    }
}
