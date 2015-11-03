@extends('layouts.master')

@section('content')
<br>
<br>
<br>
<br>
<br>
<div class="container">
    <h1>Cadastro sucesso<small> - Agora este livro esta cadastrado como parte de seus livros</small></h1>

    <?php

    $respuesta="";
     $count=0;

                //	echo "nada";
                $count++;
                //'.$livro->get().'
                $desc = $livro -> descricao;

                $respuesta.= '<div id="posibilidad row" class="posibilidad_item">';
                $respuesta.=  '<div class="col-md-3">';
                $respuesta.=  '<img  class=" thumbnail img-responsive img-rounded" src="' . $livro -> imagemurl . '" />';
                $respuesta.=  '</div>';
                $respuesta.=  '<div  class="col-md-9">';
                $respuesta.=  '<div>Título<span class="book_title"> ' . $livro -> titulo . '</span></div>';
                $respuesta.=  '<div>ISBN <span class="book_isbn">' . $livro -> isbn . '</span></div>';
                if (strlen($desc) > 20) {
                   $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
                } else {
                    $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
                }
                $respuesta.=  '<div>Publicado el<span class="book_publication">' . $livro -> ano . '</span></div>';
                $respuesta.=  '<div>Paginas <span class="book_paginas">' . $livro -> paginas . '</span></div>';

                $respuesta.=  '<hr>';
                $respuesta.=  '</div>';
                $respuesta.=  '</div>';


            echo $respuesta;
    ?>

    <div>
        <a class="btn btn-info"
        href="<?php echo action('LivroController@obterfeed',['pag' =>0 ]);?>"> Ver mais livros</a>
    </div>

</div>
<style>
    .book_title, .book_isbn,.book_publication, .book_paginas{
        font-weight:900;
        margin:5px;
        font-size:1.2em;
    }
</style>
