<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Comment extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function canDelete(User $user) : bool
    {
        if ($user->is_admin) return true;
        if ($this->user_id === $user->id)
        {
            $createTime = Carbon::parse($this->created_at);
            //$diff = Carbon::now()->diffInHours($createTime);
            $diff = Carbon::now()->diffInMinutes($createTime);
            if ($diff < 1) return true;
        }
        return false;
    }
}
