@extends('layouts.master')

@section('content')
<p>Estes são os livros cadastrados</p>
<div id="products" class="row list-group">

    @foreach ($livros as $livro)

    <div class="tl-item item col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <h4 class=" text-center group inner list-group-item-heading">
            {{$livro->titulo}}</h4>
        <div class="thumbnail">
            <img class="group list-group-image" src="{{$livro->imagemurl}}" alt="" />
            <div class="caption">

                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <a style="width: 100%" class="btn btn-success" href="http://www.jquery2dotnet.com">Quero</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-12">
            <p>
               usuário {{$livro->usuario_nome}}</p>
        </div>
    </div>


    @endforeach

@stop