<?php
 $respuesta="";
 $count=0;
   foreach ($livrosresult as $livro) {
            //	echo "nada";
            $count++;
            //'.$livro->get().'
            $desc = $livro -> getDescripcion();

            $respuesta.= '<div id="posibilidad" class="posibilidad_item">';
            $respuesta.=  '<input type="hidden" class="book_id" name="id" value="' . $livro -> getId() . '">';
            $respuesta.=  '<img  height="42" width="42" src="' . $livro -> getImageLink() . '" />';
            $respuesta.=  "<input type='hidden' class='book_img_link' value='".$livro -> getImageLink()."'>";
            $respuesta.=  'Título<span class="book_title"> ' . $livro -> getTitulo() . '</span>';
            $respuesta.=  'ISBN <span class="book_isbn">' . $livro -> getIsbn() . '</span>';
            if (strlen($desc) > 20) {
                $desc = substr($desc, 0, 20) . '...<a href="' . $livro -> getLinkPrevio() . '">Ver más</a>';
                $respuesta.=  "<input type='hidden' class='hdescrip' name='hddescrip' value='" . $livro -> getDescripcion() . "'>";
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            } else {
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            }

            $respuesta.=  'Publicado el<span class="book_publication">' . $livro -> getDataPublica() . '</span>';
            $respuesta.=  'Editora <span class="book_editora">' . $livro -> getEditora() . '</span>';
            $respuesta.=  'Paginas <span class="book_paginas">' . $livro -> getPaginas() . '</span>';
            $respuesta.=  "<input type='hidden' class='book_moreinfo_link' value='". $livro -> getLinkPrevio() ."'";
            $respuesta.=  '<span class="book_moreinfo"><a href="' . $livro -> getLinkPrevio() . '">Aquí</a></span>';
            if($livro->getAutores()){
            foreach ($livro->getAutores() as$autor ) {
                $respuesta.=  "<input type='hidden' class='livro_autor_item' value='".$autor."'>";
            }
            }
            $respuesta.="<a href='".action('LivrosController@tenho',['id' =>$livro->getId() ])."'>Tenho</a><a href='#'>Quiero</a>";
            $respuesta.=  '<hr>';

            $respuesta.=  '</div>';


        }
        echo $respuesta;
        echo $count;
?>
