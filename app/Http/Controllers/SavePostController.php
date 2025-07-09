<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class SavePostController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();

        if ($user->savedPosts()->where('post_id', $post->id)->exists()) {
            $user->savedPosts()->detach($post->id);
        } else {
            $user->savedPosts()->attach($post->id);
        }

        return back();
    }

    public function index()
    {
        $posts = Auth::user()->savedPosts()->latest()->get();
        return view('posts.saved', compact('posts'));
    }
}
