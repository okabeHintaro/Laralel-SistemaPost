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


      {{-- 🔍 Campo de busca no header --}}
      <form action="{{ route('posts.search') }}" method="GET" class="relative">
        <input
          type="text"
          name="q"
          id="search-input"
          placeholder="Buscar #tags, título ou conteúdo"
          autocomplete="off"
          class="border border-gray-300 px-3 py-1 rounded w-60"
        >
        <div id="autocomplete-results" class="absolute bg-white border border-gray-300 w-60 mt-1 rounded shadow z-10 hidden"></div>
        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
          Buscar
        </button>
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
      const query = $(this).val();
      if (query.length < 2) {
        $('#autocomplete-results').empty().addClass('hidden');
        return;
      }

      $.ajax({
        url: '{{ route("posts.autocomplete") }}',
        data: { q: query },
        success: function (data) {
          let html = '';
          if (data.length) {
            data.forEach(item => {
              html += `<div class="px-3 py-1 cursor-pointer hover:bg-gray-100" onclick="selectSuggestion('${item}')">${item}</div>`;
            });
            $('#autocomplete-results').html(html).removeClass('hidden');
          } else {
            $('#autocomplete-results').html('<div class="px-3 py-1 text-gray-500">Nenhum resultado</div>').removeClass('hidden');
          }
        }
      });
    });
  });

  function selectSuggestion(text) {
    $('#search-input').val(text);
    $('#autocomplete-results').addClass('hidden');
    $('form').submit();
  }
</script>
</body>
</html>
