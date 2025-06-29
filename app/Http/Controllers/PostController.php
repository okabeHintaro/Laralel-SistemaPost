<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    

public function index()
{
    $posts = Post::all();
    return view('home', compact('posts'));
}

public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    // Validação simples
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
    ]);

    // Criar nova postagem
    \App\Models\Post::create([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    // Redirecionar para a home
    return redirect()->route('posts.create')->with('success', 'Post criado com sucesso!');
}

public function edit(Post $post)
{
    return view('posts.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
    ]);

    $post->update($request->only('title', 'content'));

    return redirect()->route('posts.edit', $post)->with('success', 'Post atualizado com sucesso!');
}

public function destroy(Post $post)
{
    $post->delete();

    return redirect('/')->with('success', 'Post deletado com sucesso!');
}



}
