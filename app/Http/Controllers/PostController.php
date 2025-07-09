<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Tag;


class PostController extends Controller {
public function index()
{
    $posts = Post::with('user')->latest()->get();

    $oneWeekAgo = Carbon::now()->subDays(7);

    // Conta quantas vezes cada tag foi usada em posts criados na última semana
    $popularTags = DB::table('post_tag')
        ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
        ->join('posts', 'posts.id', '=', 'post_tag.post_id')
        ->where('posts.created_at', '>=', $oneWeekAgo)
        ->select('tags.id', 'tags.name', DB::raw('count(*) as count'))
        ->groupBy('tags.id', 'tags.name')
        ->orderByDesc('count')
        ->limit(10)
        ->get();

    return view('posts.index', compact('posts', 'popularTags'));
}




public function create()
{
    $tags = \App\Models\Tag::all();
    return view('posts.create', compact('tags'));
}


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'image' => 'nullable|image|max:2048',
        'tags' => 'nullable|string',
    ]);

    $data = $request->only('title', 'content');

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('posts', 'public');
        $data['image'] = $path;
    }

    $post = auth()->user()->posts()->create($data);
    auth()->user()->addEcos(5);

    // --- TAGS ---
    if ($request->filled('tags')) {
        $tagNames = explode(',', $request->tags);

        $tagIds = [];
        foreach ($tagNames as $name) {
            $trimmed = trim($name);
            if ($trimmed !== '') {
                $tag = \App\Models\Tag::firstOrCreate(['name' => $trimmed]);
                $tagIds[] = $tag->id;
            }
        }

        $post->tags()->sync($tagIds);
    }

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
    $post->load([
        'user',
        'comments' => function ($query) {
            $query->whereNull('parent_id')
                  ->with([
                      'user',
                      'replies.user',
                      'replies.parent.user' // <- importante aqui
                  ]);
        }
    ]);

    return view('posts.show', compact('post'));
}

public function search(Request $request)
{
    $query = $request->input('q');

    if (str_starts_with($query, '#')) {
        // Busca por tag
        $tagName = ltrim($query, '#');

        $tag = Tag::where('name', 'like', '%' . $tagName . '%')->first();

        if ($tag) {
            $posts = $tag->posts()->with('user')->latest()->get();
        } else {
            $posts = collect(); // Vazio
        }
    } else {
        // Busca por título, conteúdo ou descrição
        $posts = \App\Models\Post::where('title', 'like', "%$query%")
            ->orWhere('content', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->with('user')
            ->latest()
            ->get();
    }

    return view('posts.search-results', compact('posts', 'query'));
}

public function autocomplete(Request $request)
{
    $query = $request->get('q');

    $results = \App\Models\Post::where('title', 'like', "%{$query}%")
        ->orWhere('content', 'like', "%{$query}%")
        ->pluck('title')
        ->take(10)
        ->toArray();

    $tagMatches = \App\Models\Tag::where('name', 'like', "%{$query}%")
        ->pluck('name')
        ->toArray();

    return response()->json(array_unique(array_merge($results, $tagMatches)));
}


}
