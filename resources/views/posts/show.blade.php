@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-gray-800">{{ $post->title }}</h1>

        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="Imagem do post" class="w-full h-64 object-cover rounded my-4">
        @endif

        <p class="text-gray-700">{{ $post->content }}</p>
        <p class="text-sm text-gray-500 mt-4">
            Postado por <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->diffForHumans() }}
        </p>
    </div>

    {{-- Tags --}}
    <div class="mb-4">
    @foreach ($post->tags as $tag)
        <span class="inline-block bg-blue-200 text-blue-800 rounded px-2 py-1 text-xs font-semibold mr-2">
            {{ $tag->name }}
        </span>
    @endforeach
</div>


    {{-- Comentários --}}
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">Comentários</h2>

        @auth
                <form action="{{ route('posts.like', $post) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-600 hover:underline">
                {{ $post->isLikedBy(auth()->user()) ? '❤️ Curtido' : '🤍 Curtir' }}
            </button>
            <span class="text-sm text-gray-600 ml-1">{{ $post->likes_count ?? $post->likes()->count() }} curtidas</span>
        </form>
<!--salvar-->
            <form action="{{ route('posts.save', $post) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-blue-600 hover:underline">
            {{ auth()->user()->savedPosts->contains($post) ? '💾 Salvo' : '💾 Salvar' }}
        </button>
    </form>
<!--comentar-->
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <textarea name="body" rows="3" class="w-full border-gray-300 rounded p-2 mb-2" placeholder="Escreva um comentário..." required></textarea>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Enviar Comentário
                </button>
            </form>
<!---->
        @else
            <p class="text-gray-600">Você precisa <a href="{{ route('login') }}" class="underline">entrar</a> para comentar.</p>
        @endauth

        <div class="mt-6 space-y-4">
           @foreach ($post->comments as $comment)
        @include('posts.partials.comment', ['comment' => $comment])
            @endforeach
        </div>
    </div>
</div>
@endsection
