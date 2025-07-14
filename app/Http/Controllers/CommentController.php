<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request, \App\Models\Post $post)
{
    $request->validate([
        'body' => 'required|min:3',
        'parent_id' => 'nullable|exists:comments,id'
    ]);

    $comment = $post->comments()->create([
        'user_id' => auth()->id(),
        'body' => $request->body,
        'parent_id' => $request->parent_id
    ]);

    // Adiciona ecos ao autor do post (se o comentário for raiz)
    if (!$comment->parent_id) {
        $post->user->addEcos(3);
    }

    // Notifica o autor do comentário original (se for uma resposta)
    if ($comment->parent && $comment->parent->user_id !== auth()->id()) {
        $comment->parent->user->notify('reply', [
            'from_user_id' => auth()->id(),
            'from_user_name' => auth()->user()->name,
            'post_id' => $post->id,
            'post_title' => $post->title,
            'comment_content' => $comment->parent->body,
        ]);
    }


    if ($post->user_id !== auth()->id()) {
    $post->user->notify('comment', [
        'from_user_id' => auth()->id(),
        'from_user_name' => auth()->user()->name,
        'post_id' => $post->id,
        'post_title' => $post->title,
        'comment_content' => $comment->body,
    ]);
}


    return back()->with('success', 'Comentário enviado!');
}


    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
