@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-8">
    <h1 class="text-xl font-bold mb-4">🔔 Minhas Notificações</h1>

    @forelse($notifications as $notification)
      <div class="bg-white shadow p-4 rounded mb-3 {{ $notification->read ? '' : 'border-l-4 border-indigo-500' }}">
        @switch($notification->type)
          @case('like')
            <p>
              <a href="{{ route('profile.show', $notification->data['from_user_id']) }}" class="font-semibold text-indigo-600 hover:underline">
                {{ $notification->data['from_user_name'] }}
              </a> curtiu seu post 
              <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="text-indigo-600 hover:underline">
                {{ $notification->data['post_title'] }}
              </a>
            </p>
            @break

          @case('comment')
            <p>
              <a href="{{ route('profile.show', $notification->data['from_user_id']) }}" class="font-semibold text-indigo-600 hover:underline">
                {{ $notification->data['from_user_name'] }}
              </a> comentou:
              "{{ $notification->data['comment_content'] }}" 
              no post 
              <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="text-indigo-600 hover:underline">
                {{ $notification->data['post_title'] }}
              </a>
            </p>
            @break

          @case('reply')
            <p>
              <a href="{{ route('profile.show', $notification->data['from_user_id']) }}" class="font-semibold text-indigo-600 hover:underline">
                {{ $notification->data['from_user_name'] }}
              </a> respondeu seu comentário:
              <span class="italic">"{{ $notification->data['comment_content'] }}"</span> 
              no post 
              <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="text-indigo-600 hover:underline">
                {{ $notification->data['post_title'] }}
              </a>
            </p>
            @break

          @case('follow')
            <p>
              <a href="{{ route('profile.show', $notification->data['from_user_id']) }}" class="font-semibold text-indigo-600 hover:underline">
                {{ $notification->data['from_user_name'] }}
              </a> começou a te seguir.
            </p>
            @break
        @endswitch

        @if(!$notification->read)
          <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="mt-2">
            @csrf
            @method('PATCH')
            <button class="text-sm text-indigo-600 hover:underline">Marcar como lida</button>
          </form>
        @endif
      </div>
    @empty
      <p class="text-gray-500">Nenhuma notificação ainda.</p>
    @endforelse
  </div>
@endsection
