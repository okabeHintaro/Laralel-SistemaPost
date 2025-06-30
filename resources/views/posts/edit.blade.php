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

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="title">Título:</label>
    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required>

    <label for="content">Conteúdo:</label>
    <textarea name="content" id="content" required>{{ old('content', $post->content) }}</textarea>

    <label for="image">Imagem:</label>
    @if ($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="Imagem atual" style="max-width:200px; display:block; margin-bottom:10px;">
    @endif
    <input type="file" name="image" id="image" accept="image/*">

    <button type="submit">Atualizar</button>
</form>


    <p><a href="{{ url('/') }}">Voltar para lista</a></p>
</body>
</html>