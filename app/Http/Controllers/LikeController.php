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
        $post->user->increment('ecos', 2);
    }

    return back();
}
}
