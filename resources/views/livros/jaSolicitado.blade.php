@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <h1>Solicitacao nao concluida<small> - Já existe uma solicitacao previa</small></h1>

    <div>
        <a class="btn btn-info"
        href="<?php echo action('LivroController@getFeed',['pag' =>0 ]);?>"> Ver mais livros</a>
    </div>

</div>

@stop
