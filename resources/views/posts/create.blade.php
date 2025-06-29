<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Postagem</title>
</head>
<body>
    <h1>Criar nova postagem</h1>

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

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <label for="title">Título:</label><br>
        <input type="text" id="title" name="title" value="{{ old('title') }}"><br><br>

        <label for="content">Conteúdo:</label><br>
        <textarea id="content" name="content">{{ old('content') }}</textarea><br><br>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="{{ url('/') }}">Voltar para lista</a></p>
</body>
</html>