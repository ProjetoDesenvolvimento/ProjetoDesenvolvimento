@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <fieldset>
        <legend>Confirmação de cadastro</legend>
        <h3>Tem certeza que você tem este livro? </h3>
        <h3><small>Verifique que seja o mesmo que você tem em físico</small></h3>
        <form method="post" class="form" action="{!!action('LivroController@postTenho')!!}">
            <div id="posibilidad row" class="posibilidad_item">
                <input type="hidden" class="book_id" name="id" value="{{ $livro -> id }}">
                <input type="hidden" class="book_idgb" name="idgb" value="{{ $livro -> idgb }}">
                <input type='hidden' name='imagemurl' class='book_img_link' value="{{ $livro -> imagemurl}}">
                <input type="hidden" name="titulo" value="{{  $livro -> titulo }}">
                <input type="hidden" name="ano" value="{{$livro -> ano }}">
                <input type="hidden" name="isbn" value="{{$livro -> isbn}}">
                <input type='hidden' class='hdescrip' name='descricao' value="{{ $livro -> descricao }}">
                <input type="hidden" name="paginas" value="{{ $livro -> paginas }}">
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

                        @foreach ($livro->getAutores() as $autor)
                        <input type='hidden' name='autores[]' class='livro_autor_item' value=""{{$autor->nome }}">
                        @endforeach
                    </div>
                </div>
               <hr>
            </div>


        <div class="row">
            <div class="col-md-6">
                <label for="estadolivro" class="">Como está o estado do seu livro</label>
                <select name="estadolivro" class="form-control">
                    <option value="1">Bom</option>
                    <option value="2">Mais ou menos</option>
                    <option value="3">Ruim</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="enviar" class="">Confirmar</label>
                <input type="submit" class="btn form-control btn-warning" value="Confirmar">
            </div>
        </div>



        <input name="_token" type="hidden" value="<?php echo csrf_token() ?>"/>
        </form>
    <?php
        if(isset($erro)){
            echo "<h1>Um erro aconteceu e não foi possivel cadastrar</h1>";
        }
    ?>

    </fieldset>
</div>
@stop