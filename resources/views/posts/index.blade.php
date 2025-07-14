@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">

    <div class="bg-white shadow-md rounded p-4 mb-6">
  <h2 class="text-lg font-bold mb-2">👥 Sugestões de perfis</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    @foreach ($suggestedUsers as $user)
      <div class="flex items-center justify-between">
        <div>
          <p class="font-semibold text-gray-800">{{ $user->name }}</p>
          <p class="text-sm text-gray-500">{{ $user->posts_count }} posts • {{ $user->ecos ?? 0 }} ecos</p>
        </div>
        <a href="{{ route('profile.show', $user) }}" class="text-indigo-600 hover:underline text-sm">Ver perfil</a>
      </div>
    @endforeach
  </div>
</div>

        <div class="bg-white shadow-md rounded p-4 mb-6">
    <h2 class="text-lg font-bold mb-2">🔖 Tags populares da semana</h2>
    <div class="flex flex-wrap gap-2">
        @forelse ($popularTags as $tag)
            <a href="{{ route('tags.show', $tag->id) }}" class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-sm hover:bg-indigo-200">
                #{{ $tag->name }}
            </a>
        @empty
            <p class="text-gray-500">Nenhuma tag popular ainda.</p>
        @endforelse
    </div>
</div>

        

        {{-- Rankings de usuários --}}
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold mb-2">🔥 Top Usuários</h3>

            <div>
                <p class="font-semibold">Hoje:</p>
                <ul class="list-disc list-inside text-sm text-gray-700">
                    @foreach ($topToday ?? [] as $user)
                        <li>{{ $user->name }} ({{ $user->total_eco ?? 0 }} ecos)</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-3">
                <p class="font-semibold">Esta semana:</p>
                <ul class="list-disc list-inside text-sm text-gray-700">
                    @foreach ($topWeek ?? [] as $user)
                        <li>{{ $user->name }} ({{ $user->total_eco ?? 0 }} ecos)</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-3">
                <p class="font-semibold">Este mês:</p>
                <ul class="list-disc list-inside text-sm text-gray-700">
                    @foreach ($topMonth ?? [] as $user)
                        <li>{{ $user->name }} ({{ $user->total_eco ?? 0 }} ecos)</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <h1 class="text-2xl font-bold mb-6">Todas as Postagens</h1>
    @foreach ($posts as $post)
        <div class="bg-white shadow-md rounded p-4 mb-4">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            <p class="text-gray-700 mt-2">{{ $post->content }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Postado por: 
                <a href="{{ route('profile.show', $post->user) }}" class="text-indigo-500 hover:underline">
                    {{ $post->user->name }}
                </a>
            </p>

            {{-- Botão de Curtir --}}
            @auth
                <form action="{{ route('posts.like', $post) }}" method="POST" class="inline-block mt-2">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">
                        {{ $post->isLikedBy(auth()->user()) ? '❤️ Curtido' : '🤍 Curtir' }}
                    </button>
                    <span class="text-sm text-gray-600 ml-1">{{ $post->likes_count ?? $post->likes()->count() }} curtidas</span>
                </form>

<!--botao de salvar-->
                <form action="{{ route('posts.save', $post) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:underline">
                        {{ auth()->user()->savedPosts->contains($post) ? '💾 Salvo' : '💾 Salvar' }}
                    </button>
                </form>
                <span>{{ $post->savedByUsers()->count() }} pessoas salvaram este post</span>
            @endauth

            {{-- Link para acessar o post --}}
            <p class="mt-3">
                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                    ▶️ Ver Post
                </a>
            </p>
        </div>
    @endforeach

    </div>
@endsection
