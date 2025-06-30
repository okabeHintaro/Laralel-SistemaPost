<div class="mt-10">
    <h3 class="text-xl font-bold mb-4">Comentários</h3>

    @auth
        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
            @csrf
            <textarea name="body" rows="3" class="w-full border p-2 rounded" placeholder="Escreva um comentário..." required></textarea>
            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Comentar</button>
        </form>
    @else
        <p class="text-gray-500">Você precisa <a href="/login" class="underline">entrar</a> para comentar.</p>
    @endauth

    <div class="space-y-4">
        @foreach ($post->comments as $comment)
            <div class="bg-gray-100 p-4 rounded">
                <p class="text-sm text-gray-800">{{ $comment->body }}</p>
                <p class="text-xs text-gray-500 mt-1">Por {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    </div>
</div>
