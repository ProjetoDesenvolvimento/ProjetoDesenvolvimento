@extends('layouts.master')

@section('content')
    <div class="row tl-container">
        <div class="hidden-xs col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 text-center" style="padding-top:50px;">
            <h3 style="color: #fff;" >Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget vehicula risus. Nam sed condimentum nibh. Ut ac ante accumsan, sodales odio nec, pretium tellus. Donec porta erat quis aliquet hendrerit.</h3>
        </div>

        <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1" style="padding-top:30px;">
            <input  />
        </div>
        <div class="text-center col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1" style="margin-top:10px;">
            <button class="btn btn-default" type="submit">Buscar</button>
        </div>
    </div>

    <div class="row col-xs-12">
    <h3>Olá {!! $user["email"] !!}</h3>

    <div><a href="usuario/create">Criar usuario</a></div>
    <div><a href="livro/show">Mostra livros</a></div>
    <div><a href="livros/create">Cadastrar livro</a></div>
    <div><a href="livro/trocar">Trocar livro</a></div>

    </div>
@stop