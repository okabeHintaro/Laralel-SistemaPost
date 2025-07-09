<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()->with('user')->latest()->get();

        return view('tags.show', compact('tag', 'posts'));
    }



}
