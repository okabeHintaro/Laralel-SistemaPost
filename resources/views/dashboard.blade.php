@extends('layouts.app')

@section('content')
  <h1>Dashboard</h1>
  <nav>
    <ul>
      <li><a href="{{ route('posts.create') }}">Criar Postagem</a></li>
      <li><a href="{{ route('posts.index') }}">Ver Todas as Postagens</a></li>
      <li><a href="{{ route('posts.my') }}">Ver Minhas Postagens</a></li>
      <li><a href="{{ route('profile.edit') }}">Perfil</a></li>
    </ul>
  </nav>
  <p>Você está autenticado!</p>
@endsection
