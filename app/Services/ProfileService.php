<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use App\Services\ServiceExceptions\WrongUserException;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function delete(int $userId, Authenticatable $currentUser)
    {
        if ($currentUser->id !== $userId) {
            throw new WrongUserException('Only owner can delete his Profile');
        }

        $user = User::findOrFail($userId);

        $comments = Comment::where('user_id', $user->id)->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }

        $user->delete();

    }

    public function tryRestoreProfile(array $attributes)
    {
        $user = User::onlyTrashed()->where('email', $attributes['email'])->first();
        if ($user and Hash::check($attributes['password'], $user?->password)) {
            $user->restore();
            $comments = Comment::onlyTrashed()->where('user_id', $user->id)->get();
            foreach ($comments as $comment) {
                $comment->restore();
            }
        }
    }

    public function cleanOutdatedProfiles( int $days = 14)
    {
        $date = Carbon::now()->subDays($days)->format('Y-m-d H:i:s');
        $users = User::onlyTrashed()->whereDate('deleted_at', '<', $date)->get();
        foreach ($users as $user)
        {
            $comments = Comment::onlyTrashed()->where('user_id', $user->id)->get();
            foreach ($comments as $comment)
            {
                $comment->forceDelete();
            }
            $user->forceDelete();
        }
    }
}
