@extends('layouts.master')

@section('content')
<p>Estes são os livros cadastrados</p>
<div id="products" class="row list-group">

    @foreach ($livros as $livro)

    <div class="tl-item item col-lg-2 col-md-3 col-sm-4 col-xs-6">

        <div class="thumbnail">
            <h4 class=" text-center group inner list-group-item-heading">
                {{$livro->titulo}} <span class="badge">{{$livro->total}}</span></h4>
            <img class="group list-group-image" src="{{$livro->imagemurl}}" alt="" />
            <div class="caption">

                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <a style="width: 100%" class="btn btn-success" href="{{asset('livro/show-book-by-user')}}/{{$livro->id}}">Quero</a>
                    </div>
                </div>

            </div>

        </div>

    </div>


    @endforeach

@stop