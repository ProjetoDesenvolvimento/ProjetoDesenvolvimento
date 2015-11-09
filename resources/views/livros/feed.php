<?php
 $respuesta="";
 $count=0;
   foreach ($livrosresult as $livro) {
            //	echo "nada";
            $count++;
            //'.$livro->get().'
            $desc = $livro -> descricao;

            $respuesta.= '<div id="posibilidad" class="posibilidad_item">';
            $respuesta.=  '<input type="hidden" class="book_idgb" name="idgb" value="' . $livro -> idgb . '">';
            $respuesta.=  '<input type="hidden" class="book_id" name="id" value="' . $livro -> id . '">';
            $respuesta.=  '<img  height="42" width="42" src="' . $livro -> imagemurl . '" />';
            $respuesta.=  "<input type='hidden' class='book_img_link' value='".$livro -> imagemurl."'>";
            $respuesta.=  'Título<span class="book_title"> ' . $livro -> titulo . '</span>';
            $respuesta.=  'ISBN <span class="book_isbn">' . $livro -> isbn . '</span>';
            if (strlen($desc) > 20) {

                $respuesta.=  "<input type='hidden' class='hdescrip' name='hddescrip' value='" . $livro -> descricao . "'>";
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            } else {
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            }

            $respuesta.=  'Publicado el<span class="book_publication">' . $livro -> ano . '</span>';
           // $respuesta.=  'Editora <span class="book_editora">' . $livro -> getEditora() . '</span>';
            $respuesta.=  'Paginas <span class="book_paginas">' . $livro ->paginas . '</span>';
          //  $respuesta.=  "<input type='hidden' class='book_moreinfo_link' value='". $livro -> getLinkPrevio() ."'";
            //$respuesta.=  '<span class="book_moreinfo"><a href="' . $livro -> getLinkPrevio() . '">Aquí</a></span>';
            if($livro->getAutores()){
            foreach ($livro->getAutores() as$autor ) {
                $respuesta.=  "<input type='hidden' class='livro_autor_item' value='".$autor->nome."'>";
            }
            }
            if($livro->id>0&&strlen($livro->idgb)>0){
            $respuesta.="<a href='".action('LivroController@tenho',[$livro->idgb ,$livro->id])."'>Tenho</a><a href='#'>Quiero</a>";
            }else if(strlen($livro->idgb)>0){
            $respuesta.="<a href='".action('LivroController@tenho',[$livro->idgb,0])."'>Tenho</a><a href='#'>Quiero</a>";
            }else if($livro->id>0){
            $respuesta.="<a href='".action('LivroController@tenho',["-",$livro->id])."'>Tenho</a><a href='#'>Quiero</a>";
            }


            $respuesta.=  '<hr>';

            $respuesta.=  '</div>';


        }
        echo $respuesta;
        if(isset($start)){
            if($start>0){
                echo "<a href='".action('LivroController@obterfeed',['pag' =>$start-1 ])."'>Anterior</a>";
            }
            echo "<a href='".action('LivroController@obterfeed',['pag' =>$start+1 ])."'>Siguiente</a>";
        }
        echo $count;
?>
