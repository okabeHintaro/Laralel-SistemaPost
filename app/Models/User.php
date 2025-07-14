<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    ];


    // app/Models/Post.php
public function posts()
{
    return $this->hasMany(Post::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

// User.php

public function following()
{
    return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')->withTimestamps();
}

public function followers()
{
    return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')->withTimestamps();
}


// Verifica se o usuário segue outro
public function isFollowing(User $user)
{
    return $this->following->contains($user);
}

public function ecos()
{
    return $this->hasMany(Eco::class);
}

public function addEcos(int $amount, string $reason = null): void
{
    $this->increment('ecos', $amount); // atualiza campo 'ecos' no perfil

    $this->ecos()->create([
        'amount' => $amount,
        'reason' => $reason
    ]);
}


public function likes()
{
    return $this->hasMany(Like::class);
}

public function savedPosts()
{
    return $this->belongsToMany(Post::class, 'post_saves')->withTimestamps();
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}

public function notify(string $type, array $data = [])
{
    $this->notifications()->create([
        'type' => $type,
        'data' => $data,
        'read' => false,
    ]);
}


}
