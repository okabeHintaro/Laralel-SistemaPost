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

public function likes()
{
    return $this->hasMany(Like::class);
}

public function isLikedBy(User $user)
{
    return $this->likes()->where('user_id', $user->id)->exists();
}

public function likesCount()
{
    return $this->likes()->count();
}

public function savedByUsers()
{
    return $this->belongsToMany(User::class, 'post_saves')->withTimestamps();
}

public function tags()
{
    return $this->belongsToMany(Tag::class);
}



}
