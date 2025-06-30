<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id', 'image'];


   public function user()
{
    return $this->belongsTo(User::class);
}


// app/Models/User.php
// app/Models/User.php

public function posts()
{
    return $this->hasMany(Post::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}


}
