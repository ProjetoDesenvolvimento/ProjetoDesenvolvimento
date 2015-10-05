<?php
        $respuesta="";
       foreach ($livrosarray as $livro) {
            //	echo "nada";
            //'.$livro->get().'
            $desc = $livro -> descricao;

            $respuesta.= '<div id="posibilidad" class="posibilidad_item">';
            $respuesta.=  '<input type="hidden" class="book_id" name="id" value="' . $livro -> idgb . '">';
            $respuesta.=  '<img  height="42" width="42" src="' . $livro -> imagemurl . '" />';
            $respuesta.=  "<input type='hidden' id='book_imglink' class='book_img_link' value='".$livro -> imagemurl."'>";
            $respuesta.=  'Título<span class="book_title"> ' . $livro -> titulo. '</span>';
            $respuesta.=  'ISBN <span class="book_isbn">' . $livro -> isbn . '</span>';
            if (strlen($desc) > 20) {
                //$desc = substr($desc, 0, 20) . '...<a href="' . $livro -> getLinkPrevio() . '">Ver más</a>';
                $respuesta.=  "<input type='hidden' class='hdescrip' name='hddescrip' value='" . $livro -> descricao . "'>";
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            } else {
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            }

            $respuesta.=  'Publicado el<span class="book_publication">' . $livro -> ano . '</span>';
           // $respuesta.=  'Editora <span class="book_editora">' . $livro -> getEditora() . '</span>';
            $respuesta.=  'Paginas <span class="book_paginas">' . $livro -> paginas . '</span>';
          //  $respuesta.=  "<input type='hidden' class='book_moreinfo_link' value='". $livro -> getLinkPrevio() ."'";
            //$respuesta.=  '<span class="book_moreinfo"><a href="' . $livro -> getLinkPrevio . '">Aquí</a></span>';
            if($livro->getAutores()){
            foreach ($livro->getAutores() as $autor ) {
                $respuesta.=  "<input type='hidden' class='livro_autor_item' value='".$autor->nome."'>";
            }
            }

            $respuesta.=  '<hr>';

            $respuesta.=  '</div>';

            //echo "<option>" . $libro -> getIsbn().'</option>';
        }
            $respuesta.=  "<script>addHandlingToPosibilities();</script>";
            echo "respuesta es ".$respuesta;

?>
