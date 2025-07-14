<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post)
{
    $user = Auth::user();

    if ($post->isLikedBy($user)) {
        // Remove a curtida
        $post->likes()->where('user_id', $user->id)->delete();

        // Remove os ecos do autor do post
        $post->user->decrement('ecos', 2);
    } else {
        // Adiciona a curtida
        $post->likes()->create(['user_id' => $user->id]);

        // Adiciona ecos ao autor do post
        $post->user->addEcos(2, "recebeu uma curtida");

        // Dentro de toggle()

if ($post->user->id !== $user->id) {
    $post->user->notify('like', [
        'from_user_id' => $user->id,
        'from_user_name' => $user->name,
        'post_id' => $post->id,
        'post_title' => $post->title,
    ]);
}

    }

    

    return back();
}
}
