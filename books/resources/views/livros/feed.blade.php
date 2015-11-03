@extends('layouts.master')
@section('content')
</br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
<style>
  .posibilidad_item{
    margin:15px;
    margin-top:50px;
    float:left !important;
    height:450px;
  }
  .item_botones{
    float:bottom;
  }
</style>
    <fieldset>
        <legend>Feed de Livros</legend>
            <div id="products" class="row list-group">
            <?php

             $respuesta="";
             $count=0;

               foreach ($livrosresult as $livro) {
                        //	echo "nada";
                        $count++;
                        //'.$livro->get().'
                        $desc = $livro -> descricao;

                        $respuesta.= '<div  class="posibilidad_item tl-item item col-lg-2 col-md-3 col-sm-4 col-xs-6">';
                        $respuesta.=  '<input type="hidden" class="book_idgb" name="idgb" value="' . $livro -> idgb . '">';
                        $respuesta.=  '<input type="hidden" class="book_id" name="id" value="' . $livro -> id . '">';
                         if (strlen($livro -> titulo) > 25) {

                            $respuesta.=  '<span class="text-center group  inner list-group-item-heading"> ' . substr ($livro -> titulo,0,25) . '...</span>';

                        } else {
                            $respuesta.=  '<span class="text-center group  inner list-group-item-heading"> ' . $livro -> titulo. '</span>';
                        }

                        $respuesta.=  '<hr>';
                        $respuesta.=  '<img  class="thumbnail" src="' . $livro -> imagemurl . '" />';
                        $respuesta.=  "<input type='hidden' class='book_img_link' value='".$livro -> imagemurl."'>";
                        $respuesta.=  '<div>ISBN <span class="book_isbn">' . $livro -> isbn . '</span></div>';
                        if (strlen($desc) > 20) {

                            $respuesta.=  "<input type='hidden' class='hdescrip' name='hddescrip' value='" . $livro -> descricao . "'>";
                            //$respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
                        } else {
                           // $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
                        }

                        $respuesta.=  '<div>Publicado : <span class="book_publication">' . $livro -> ano . '</span></div>';
                       // $respuesta.=  'Editora <span class="book_editora">' . $livro -> getEditora() . '</span>';
                        if (strlen($livro ->paginas ) > 0) {

                            $respuesta.=  '<div>Paginas <span class="book_paginas">' . $livro ->paginas . '</span></div>';
                        }

                      //  $respuesta.=  "<input type='hidden' class='book_moreinfo_link' value='". $livro -> getLinkPrevio() ."'";
                        //$respuesta.=  '<span class="book_moreinfo"><a href="' . $livro -> getLinkPrevio() . '">Aquí</a></span>';
                        if($livro->getAutores()){
                        foreach ($livro->getAutores() as$autor ) {
                            $respuesta.=  "<input type='hidden' class='livro_autor_item' value='".$autor->nome."'>";
                        }
                        }
                        $respuesta.="<div class='row item_botones'>";

                        if($livro->id>0&&strlen($livro->idgb)>0){
                        $respuesta.="<div class='col-xs-6'><a class='btn btn-success' href='".action('LivroController@tenho',[$livro->idgb ,$livro->id])."'>Tenho</a></div><div class='col-xs-6'><a class='btn btn-warning' href='#'>Quero</a></div>";
                        }else if(strlen($livro->idgb)>0){
                        $respuesta.="<div class='col-xs-6'><a class='btn btn-success' href='".action('LivroController@tenho',[$livro->idgb,0])."'>Tenho</a></div><div class='col-xs-6'><a  class='btn btn-warning' href='#'>Quero</a></div>";
                        }else if($livro->id>0){
                        $respuesta.="<div class='col-xs-6'><a class='btn btn-success' href='".action('LivroController@tenho',["-",$livro->id])."'>Tenho</a></div><div class='col-xs-6'><a  class='btn btn-warning' href='#'>Quero</a></div>";
                        }

                        $respuesta.=  '</div>';


                        $respuesta.=  '</div>';


                    }
                    echo $respuesta;

            ?>
            </div>
            <?php
                     echo "<div>";
                        if(isset($start)){
                            if($start>0){
                                echo "<a href='".action('LivroController@obterfeed',['pag' =>$start-1 ])."'><span class='glyphicon glyphicon-arrow-left'></span> Anterior</a>";
                            }
                            echo "<a href='".action('LivroController@obterfeed',['pag' =>$start+1 ])."'>Siguiente <span class='glyphicon glyphicon-arrow-right'></span></a>";
                        }
                    echo  '</div>';

                    ?>
    </fieldset>

</div>
