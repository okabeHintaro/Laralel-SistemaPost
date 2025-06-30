@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Todas as Postagens</h1>

        @foreach ($posts as $post)
            <div class="bg-white shadow-md rounded p-4 mb-4">
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                <p class="text-gray-700 mt-2">{{ $post->content }}</p>
                <p class="text-sm text-gray-500 mt-4">Autor: {{ $post->user->name }}</p>
            </div>
        @endforeach
    </div>
@endsection
