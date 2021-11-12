<?php

namespace App\Services;

use App\Models\User;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    /**
     * @param Authenticatable $user
     */
    public function delete(Authenticatable $user)
    {
        /** @var User $user */
        $comments = $user->comments;
        foreach ($comments as $comment) {
            $comment->delete();
        }
        $user->delete();
    }

    public function tryRestoreProfile($email, $password)
    {
        $user = User::onlyTrashed()->where('email', $email)->first();
        if ($user && Hash::check($password, $user?->password)) {
            $user->restore();
            $comments = $user->comments()->onlyTrashed()->get();
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
            $comments = $user->comments()->onlyTrashed()->get();
            foreach ($comments as $comment)
            {
                $comment->forceDelete();
            }
            $user->forceDelete();
        }
    }
}
