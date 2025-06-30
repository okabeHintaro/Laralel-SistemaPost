<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    


public function index()
{
    // Busca as postagens junto com o usuário autor
    $posts = \App\Models\Post::with('user')->latest()->get();

    // Passa a variável $posts para a view 'posts.index'
    return view('posts.index', compact('posts'));
}



public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'image' => 'nullable|image|max:2048', // max 2MB
    ]);

    $data = $request->only('title', 'content');

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('posts', 'public');
        $data['image'] = $path;
    }

    auth()->user()->posts()->create($data);

    return redirect()->route('posts.my')->with('success', 'Post criado com sucesso!');
}


public function myPosts()
{
    // Pega só os posts do usuário logado, com o relacionamento user
    $posts = auth()->user()->posts()->with('user')->latest()->get();

    return view('posts.my-posts', compact('posts'));
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
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->only('title', 'content');

    if ($request->hasFile('image')) {
        // Apaga a imagem antiga, se existir
        if ($post->image && \Storage::disk('public')->exists($post->image)) {
            \Storage::disk('public')->delete($post->image);
        }

        // Salva a nova imagem
        $path = $request->file('image')->store('posts', 'public');
        $data['image'] = $path;
    }

    $post->update($data);

    return redirect()->route('posts.my')->with('success', 'Post atualizado com sucesso!');
}


public function destroy(Post $post)
{
    $post->delete();

    return redirect('/')->with('success', 'Post deletado com sucesso!');
}

public function show(Post $post)
    {
        // Carrega usuário autor e comentários (com usuário de cada comentário)
        $post->load(['user', 'comments.user']);

        return view('posts.show', compact('post'));
    }



}
