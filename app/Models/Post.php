<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comments;
use App\Models\User;

class Post extends Model
{

    protected $fillable = ["title", "status", "content", "user_id"];

    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
