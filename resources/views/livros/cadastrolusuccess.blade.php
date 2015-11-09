@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <h1>Cadastro realizado com sucesso<small> - Agora este livro esta cadastrado como parte de seus livros</small></h1>
    <div id="posibilidad row" class="posibilidad_item">
    <div class="col-lg-3 col-md-3 col-sd-2 col-xs-12">
    <img  class="cover-img thumbnail img-responsive img-rounded" src="{{ $livro -> imagemurl }}" />
    </div>
    <div  class="col-md-9">
        <div>Título<span class="book_title"> {{ $livro -> titulo }}</span></div>
        <div>ISBN <span class="book_isbn">{{ $livro -> isbn }}</span></div>
        <div>Descriçao <span class="book_description">{{ $livro->descricao }}</span></div>

        <div>Publicado en<span class="book_publication">{{ $livro -> ano  }}</span></div>
        <div>Páginas <span class="book_paginas">{{$livro -> paginas }}</span></div>
        <hr>
    </div>
    </div>

    <div>
        <a class="btn btn-info"
        href="<?php echo action('LivroController@getFeed',['pag' =>0 ]);?>"> Ver mais livros</a>
    </div>

</div>
<style>
    .book_title, .book_isbn,.book_publication, .book_paginas{
        font-weight:900;
        margin:5px;
        font-size:1.2em;
    }
</style>
@stop