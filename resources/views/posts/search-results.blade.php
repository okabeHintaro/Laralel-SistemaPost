@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">🔍 Resultados da busca: <em>{{ $query }}</em></h1>

    @forelse ($posts as $post)
        <div class="bg-white shadow-md rounded p-4 mb-4">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-700 mt-2">{{ Str::limit($post->content, 150) }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Postado por: 
                <a href="{{ route('profile.show', $post->user) }}" class="text-indigo-500 hover:underline">
                    {{ $post->user->name }}
                </a>
            </p>
            <p class="mt-3">
                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">▶️ Ver Post</a>
            </p>
        </div>
    @empty
        <p class="text-gray-500">Nenhum resultado encontrado.</p>
    @endforelse
</div>
@endsection
