<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Meu Sistema de Postagens</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold">
        <a href="{{ route('posts.index') }}" class="text-indigo-600">Sistema de Postagens</a>
      </h1>

      @auth
  @php
      $unreadCount = auth()->user()->notifications()->where('read', false)->count();
  @endphp
  <a href="{{ route('notifications.index') }}" class="text-gray-700 hover:text-indigo-600">
    🔔 Notificações 
    @if ($unreadCount)
      <span class="text-red-600 font-bold">({{ $unreadCount }})</span>
    @endif
  </a>
@endauth


      {{-- 🔍 Campo de busca no header --}}
      <form action="{{ route('posts.search') }}" method="GET" class="relative">
        <input
            type="text"
            name="q"
            id="search-input"
            placeholder="Buscar #tags, título ou conteúdo"
            class="border border-gray-300 px-3 py-1 rounded w-60"
            autocomplete="off"
        >
        <div id="autocomplete-results" class="absolute bg-white border w-60 shadow hidden z-10"></div>
    </form>

      <nav class="space-x-4">
        @auth
          <a href="{{ route('posts.my') }}" class="text-gray-700 hover:text-indigo-600">Meus Posts</a>
          <a href="{{ route('posts.saved') }}" class="text-gray-700 hover:text-indigo-600">💾 Salvos</a>
          <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-indigo-600">Perfil</a>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-red-500 hover:underline">Sair</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Entrar</a>
          <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600">Registrar</a>
        @endauth
      </nav>
    </div>
  </header>

  <main class="py-6">
    @yield('content')
  </main>

  <footer class="bg-white text-center text-sm py-4 mt-10 border-t">
    &copy; {{ date('Y') }} Sistema de Postagens
  </footer>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#search-input').on('input', function () {
      let query = $(this).val();
      if (query.length < 1) {
        $('#autocomplete-results').empty().addClass('hidden');
        return;
      }

      $.get('{{ route("posts.autocomplete") }}', { q: query }, function (data) {
        let html = '';
        if (data.length) {
          data.forEach(item => {
            html += `<div class="px-3 py-1 cursor-pointer hover:bg-gray-100" onclick="selectTag('${item}')">${item}</div>`;
          });
        } else {
          html = `<div class="px-3 py-1 text-gray-500">Nenhum resultado</div>`;
        }
        $('#autocomplete-results').html(html).removeClass('hidden');
      });
    });
  });

  function selectTag(value) {
    $('#search-input').val(value);
    $('#autocomplete-results').addClass('hidden');
    $('#search-input').closest('form').submit();
  }
</script>

</body>
</html>
