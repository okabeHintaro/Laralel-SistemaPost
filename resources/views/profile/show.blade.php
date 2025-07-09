@extends('layouts.app')

@section('title', 'Perfil de ' . $user->name)

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        Perfil de {{ $user->name }}
    </h2>

    @auth
    @if (auth()->id() !== $user->id)
        <form method="POST" action="{{ route('usuarios.seguir', $user) }}">
            @csrf
            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                {{ auth()->user()->isFollowing($user) ? 'Deixar de seguir' : 'Seguir' }}
            </button>
        </form>
    @endif
@endauth

    <p><strong>Seguidores:</strong> {{ $user->followers()->count() }}</p>
    <p>Pontos Ecos: {{ $user->ecos }}</p>


    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-2xl font-bold mb-4">Posts de {{ $user->name }}</h3>

            @forelse ($user->posts as $post)
                <div class="mb-6 border-b pb-4">
                    <h4 class="text-xl font-semibold">{{ $post->title }}</h4>
                    <p class="text-gray-600 mt-1">{{ $post->description }}</p>
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Imagem do post" class="mt-3 rounded w-full max-w-md">
                    @endif
                    <p class="text-sm text-gray-500 mt-2">Publicado em {{ $post->created_at->format('d/m/Y') }}</p>
                </div>
            @empty
                <p class="text-gray-600">Este usuário ainda não publicou nenhum post.</p>
            @endforelse
        </div>
    </div>
@endsection
