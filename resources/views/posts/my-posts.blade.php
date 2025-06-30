@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Postagens</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Imagem do post" class="w-full h-48 object-cover rounded-t-lg">
                @endif

                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-600 mb-4">{{ Str::limit($post->content, 100) }}</p>

                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>Autor: {{ $post->user->name }}</span>

                        <a href="{{ route('posts.edit', $post) }}" class="text-indigo-500 hover:underline">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($posts->isEmpty())
        <p class="text-center text-gray-500 mt-6">Nenhuma postagem encontrada.</p>
    @endif
</div>
@endsection
