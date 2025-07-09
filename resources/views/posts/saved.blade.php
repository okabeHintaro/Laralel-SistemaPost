@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Postagens Salvas</h1>

    @forelse ($posts as $post)
        <div class="bg-white shadow-md rounded p-4 mb-4">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-700 mt-2">{{ $post->content }}</p>
            <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:underline">▶️ Ver Post</a>
        </div>
    @empty
        <p class="text-gray-500">Você ainda não salvou nenhuma postagem.</p>
    @endforelse
</div>
@endsection
