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

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="title">Título:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="content">Conteúdo:</label><br>
    <textarea name="content" id="content" required></textarea><br><br>

    <label for="image">Imagem:</label><br>
    <input type="file" name="image" id="image" accept="image/*"><br><br>

    <label for="tags">Tags (separe por vírgula):</label><br>
    <input type="text" name="tags" id="tags" placeholder="ex: laravel, php, backend"><br><br>

    <button type="submit">Salvar</button>
</form>


    <p><a href="{{ url('/') }}">Voltar para lista</a></p>
</body>
</html>
