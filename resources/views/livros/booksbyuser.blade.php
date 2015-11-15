@extends('layouts.master')

@section('content')
<p>Estes são os livros do usuario {{$usuarionome}}</p>
<div id="products" class="row list-group">
    @foreach ($livros as $livro)
    <div class="tl-item item col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <div class="thumbnail">
            <h4 class=" text-center group inner list-group-item-heading">
                {{$livro->titulo}}</h4>
            <img class="group list-group-image" src="{{$livro->imagemurl}}" alt="" />
            <div class="caption">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <a style="width: 100%" class="btn btn-success" href="{{asset('livro/solicitar-troca')}}/{{$livro->livrousuario_id}}">Solicitar troca</a>
                    </div>
                </div>
            </div>
            <p class=" text-center">
                de {{$livro->usuario_nome}}</p>
        </div>
    </div>
    @endforeach
 @stop
