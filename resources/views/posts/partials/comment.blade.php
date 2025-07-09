<div class="bg-gray-100 p-4 rounded">
  <p class="text-gray-800">
    @if ($comment->parent)
      <span class="text-sm text-gray-500">Resposta para <strong>{{ $comment->parent->user->name }}</strong>:</span><br>
    @endif
    {{ $comment->body }}
  </p>

  <p class="text-sm text-gray-500 mt-1">
    Por <strong>{{ $comment->user->name }}</strong> • {{ $comment->created_at->diffForHumans() }}
  </p>

  @auth
  <form method="POST" action="{{ route('comments.store', $comment->post) }}" class="mt-2">
    @csrf
    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
    <textarea name="body" rows="2" class="w-full border rounded p-2 mb-2" placeholder="Responder..."></textarea>
    <button type="submit" class="text-sm text-blue-600 hover:underline">Responder</button>
  </form>
  @endauth

  {{-- Exibe as respostas indentadas --}}
  @if ($comment->replies->count())
  <div class="ml-8 mt-4 border-l-2 border-blue-300 pl-4 space-y-4">
    @foreach ($comment->replies as $reply)
      @include('posts.partials.comment', ['comment' => $reply])
    @endforeach
  </div>
  @endif
</div>
