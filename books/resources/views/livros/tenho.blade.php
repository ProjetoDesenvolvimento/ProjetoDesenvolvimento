@extends('layouts.master')

@section('content')
<br>
<div class="container">
    <fieldset>
        <legend>Confirmacao da tentativa de cadastro</legend>
        <h1>Tem certeza que voce tem este livro? <small>Verifique que seja o mesmo que vocë tem em físico</small></h1>


<?php
$acti="";
            if($livro->id>0&&strlen($livro->idgb)>0){
            $acti=action('LivroController@cadastrarLivroUsuario',[$livro->idgb ,$livro->id]);
            }else if(strlen($livro->idgb)>0){
            $acti=action('LivroController@cadastrarLivroUsuario',[$livro->idgb,0]);
            }else if($livro->id>0){
            $acti=action('LivroController@cadastrarLivroUsuario',[$livro->id]);
            }
?>
<form method="post" class="form" action="<?php echo $acti;?>">
<?php

$respuesta="";
 $count=0;

            //	echo "nada";
            $count++;
            //'.$livro->get().'
            $desc = $livro -> descricao;

            $respuesta.= '<div id="posibilidad row" class="posibilidad_item">';
            $respuesta.=  '<input type="hidden" class="book_id" name="id" value="' . $livro -> id . '">';
            $respuesta.=  '<input type="hidden" class="book_idgb" name="idgb" value="' . $livro -> idgb . '">';
            $respuesta.=  '<div class="col-md-3">';
            $respuesta.=  '<img  class=" thumbnail img-responsive img-rounded" src="' . $livro -> imagemurl . '" />';
            $respuesta.=  '</div>';
            $respuesta.=  "<input type='hidden' name='imagemurl' class='book_img_link' value='".$livro -> imagemurl."'>";
            $respuesta.=  '<div  class="col-md-9">';
            $respuesta.=  '<div>Título<span class="book_title"> ' . $livro -> titulo . '</span></div>';
            $respuesta.=  '<input type="hidden" name="titulo" value="' . $livro -> titulo . '">';
            $respuesta.=  '<div>ISBN <span class="book_isbn">' . $livro -> isbn . '</span></div>';
            $respuesta.=  '<input type="hidden" name="isbn" value="' . $livro -> isbn . '">';
            $respuesta.=  "<input type='hidden' class='hdescrip' name='descricao' value='" . $livro -> descricao . "'>";
            if (strlen($desc) > 20) {
             //   $desc = substr($desc, 0, 20) . '...<a href="' . $livro -> getLinkPrevio() . '">Ver más</a>';
                $respuesta.=  "<input type='hidden' class='hdescrip' name='descricao' value='" . $livro -> descricao . "'>";
               $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            } else {
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            }

            $respuesta.=  '<div>Publicado el<span class="book_publication">' . $livro -> ano . '</span></div>';
            $respuesta.=  '<input type="hidden" name="ano" value="' . $livro -> ano. '">';
           // $respuesta.=  'Editora <span class="book_editora">' . $livro -> getEditora() . '</span>';
           // $respuesta.=  '<input type="hidden" name="editora" value="' . $livro -> getEditora() . '">';
            $respuesta.=  '<div>Paginas <span class="book_paginas">' . $livro -> paginas . '</span></div>';
            $respuesta.=  '<input type="hidden" name="paginas" value="' . $livro -> paginas . '">';
          //  $respuesta.=  "<input type='hidden' class='book_moreinfo_link' name='linkprevio' value='". $livro -> getLinkPrevio() ."'";
          //  $respuesta.=  '<span class="book_moreinfo"><a href="' . $livro -> getLinkPrevio() . '">Aquí</a></span>';
            $cantidadautores=count($livro->getAutores());
            //echo $cantidadautores."estooooooooooooo";
            if($cantidadautores>0){
                foreach ($livro->getAutores() as $autor ) {
                    $respuesta.=  "<input type='hidden' name='autores[]' class='livro_autor_item' value='".$autor->nome."'>";
                }
            }

            $respuesta.=  '<hr>';
            $respuesta.=  '</div>';
            $respuesta.=  '</div>';


        echo $respuesta;
?>
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

<style>
    .book_title, .book_isbn,.book_publication, .book_paginas{
        font-weight:900;
        margin:5px;
        font-size:1.2em;
    }
</style>
