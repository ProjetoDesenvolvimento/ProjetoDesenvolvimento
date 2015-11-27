@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <fieldset>
        <legend>Cadastro realizado com sucesso</legend>
        <h3>Agora este livro esta cadastrado como parte de seus livros</h3>
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <img class="cover-img thumbnail img-responsive img-rounded" src="{{ $livro -> imagemurl }}" />
                </div>

                <div  class="col-sm-8 col-xs-12">
                    <h2><span class="book_title">{{  $livro -> titulo }}</span></h2>

                    <p class="text-justify"><small></small></p>
                    <p><small><strong>Data de publicação: </strong>{{$livro -> ano }}</small></p>

                    <p><small><strong>Páginas: </strong>{{ $livro -> paginas }}</small></p>
                    <p><small><strong>ISBN: </strong> {{ $livro -> isbn }}</small></p>

                    <div>
                        <a class="btn btn-info"
                           href="<?php echo action('LivroController@getFeed',['pag' =>0 ]);?>"> Ver mais livros</a>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </fieldset>
</div>
@stop