@extends('layouts.master')

@section('content')
<div class="container-fluid">
<fieldset>
        <legend>Confirmação de cadastro</legend>
        <h1>Tem certeza que você tem este livro? </h1>
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

        <div class="col-md-3 ">
            <img class="cover-img thumbnail img-responsive img-rounded" src="{{ $livro -> imagemurl }}" />
        </div>

        <div  class="col-md-9">
        <div>Título<span class="book_title"> {{  $livro -> titulo }}</span></div>

        <div>ISBN <span class="book_isbn"> {{ $livro -> isbn }}</span></div>

        <span class="book_description">{{ $livro->descricao }}</span>
        <div>Publicado em<span class="book_publication">{{$livro -> ano }}</span></div>



        <div>Páginas<span class="book_paginas"> {{ $livro -> paginas }}</span></div>



        @foreach ($livro->getAutores() as $autor)
        <input type='hidden' name='autores[]' class='livro_autor_item' value=""{{$autor->nome }}">

            @endforeach

       <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-4 ">
                 Como esta o estado do seu livro
                <select name="estadolivro" class="form-control">
					<option value="1">Bom</option>
					<option value="2">Mais ou menos</option>
					<option value="3">Ruim</option>

				</select>
    </div>
    <div class="col-md-3">

            <label for="enviar" class="">Confirmar</label>
            <input type="submit" class="btn form-control btn-warning" value="Confirmar">

    </div>
</div>



<input name="_token" type="hidden" value="<?php echo csrf_token() ?>"/>
</form>
<?php
    if(isset($erro)){
        echo "<h1>Um erro aconteceu e nao foi possivel cadastrar</h1>";
    }
?>

    </fieldset>
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