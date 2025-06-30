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

    {{-- Comentários --}}
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">Comentários</h2>

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <textarea name="body" rows="3" class="w-full border-gray-300 rounded p-2 mb-2" placeholder="Escreva um comentário..." required></textarea>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Enviar Comentário
                </button>
            </form>
        @else
            <p class="text-gray-600">Você precisa <a href="{{ route('login') }}" class="underline">entrar</a> para comentar.</p>
        @endauth

        <div class="mt-6 space-y-4">
            @forelse ($post->comments as $comment)
                <div class="bg-gray-100 p-4 rounded">
                    <p class="text-gray-800">{{ $comment->body }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        Por <strong>{{ $comment->user->name }}</strong> • {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Nenhum comentário ainda.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
