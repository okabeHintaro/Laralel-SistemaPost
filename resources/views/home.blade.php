<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Postagens</title>
</head>
<body>
    <h1>Bem-vindo ao sistema de postagens!</h1>

   @foreach($posts as $post)
    <article>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>

        <a href="{{ route('posts.edit', $post) }}">Editar</a>

        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Quer mesmo deletar?')">Deletar</button>
        </form>

        <hr>
    </article>
@endforeach

</body>
</html>
