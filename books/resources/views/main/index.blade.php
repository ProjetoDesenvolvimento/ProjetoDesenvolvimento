@extends('layouts.master')

@section('content')
<h3>Olá {!! $user["email"] !!}</h3>

<div><a href="usuario/create">Criar usuario</a></div>
<div><a href="livro/show">Mostra livros</a></div>
<div><a href="livros/create">Cadastrar livro</a></div>


@stop