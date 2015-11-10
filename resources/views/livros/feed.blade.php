@extends('layouts.master')
@section('content')

<div class="container-fluid">
<style>
  .posibilidad_item{
      height:500px;
      margin-bottom: 20px;
      padding:10px;
  }
  .posibilidad_item:hover{
      background-color: #EEE;
  }
  .item_botones{
    margin-top: 10px;
  }
</style>
    <p>Estes são os livros que você pode trocar ou cadastrar</p>
    <div id="products" class="row list-group">
        @foreach ($livrosresult as $livro)
        <div class="posibilidad_item tl-item item col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <h3 class="text-center group inner list-group-item-heading ">
                <small>{{$livro->titulo}}</small> <span class="badge">{{$livro->total}}</span>
            </h3>
            <hr/>
            <div class="center-block">
                <div class="thumbnail ">
                    <img class="img-responsive group list-group-image" src="{{$livro->imagemurl}}" alt="" />
                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 col-md-12">
                    ISBN: <span class="book_isbn">{{  $livro -> isbn }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    Publicado : <span class="book_publication"> {{ $livro -> ano }} </span>
                </div>
            </div>
            <div class="caption">

                <div class="row top-buffer">
                    <div class=" col-md-6 item_botones">
                        <a style="width: 100%" class="btn btn-success {{$livro->total == 0 ? 'disabled' : '' }}" href="{{asset('livro/show-book-by-user')}}/{{$livro->id}}">Quero</a>
                    </div>
                    <div class="col-md-6 item_botones">
                        <a style="width: 100%" class="btn btn-warning" href="{{asset('livro/tenho')}}/{{$livro->idgb}}/{{$livro->id}}">Tenho</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="clearfix"></div>
        <div class="row">
                <div class="col-md-6">
                    <?php

                    if(isset($start)){
                    if($start>0) {
                        ?>
                    <a  href="{{asset('livro/feed')}}/{{$start - 1}}">
                    <span class='glyphicon gly glyphicon-arrow-left'>
                    </span> Anterior</a>
                    <?php
                    }
                    ?>

                </div>
                <div class="col-md-6">
                <a class="pull-right" href="{{asset('livro/feed')}}/{{$start + 1}}"> Próxima <span class='glyphicon glyphicon-arrow-right'></span></a>
                    </div>
            </div>
            <?php
        }
        ?>
        </div>

@stop