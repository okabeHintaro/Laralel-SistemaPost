<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Postagem</title>
</head>
<body>
    <h1>Editar postagem</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Título:</label><br>
        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"><br><br>

        <label for="content">Conteúdo:</label><br>
        <textarea id="content" name="content">{{ old('content', $post->content) }}</textarea><br><br>

        <button type="submit">Atualizar</button>
    </form>

    <p><a href="{{ url('/') }}">Voltar para lista</a></p>
</body>
</html>