
<h1>Tem certeza que voce tem este livro?</h1>
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
<form method="post" action="<?php echo $acti;?>">
<?php

$respuesta="";
 $count=0;

            //	echo "nada";
            $count++;
            //'.$livro->get().'
            $desc = $livro -> descricao;

            $respuesta.= '<div id="posibilidad" class="posibilidad_item">';
            $respuesta.=  '<input type="hidden" class="book_id" name="id" value="' . $livro -> id . '">';
            $respuesta.=  '<input type="hidden" class="book_idgb" name="idgb" value="' . $livro -> idgb . '">';
            $respuesta.=  '<img  height="42" width="42" src="' . $livro -> imagemurl . '" />';
            $respuesta.=  "<input type='hidden' name='imagemurl' class='book_img_link' value='".$livro -> imagemurl."'>";
            $respuesta.=  'Título<span class="book_title"> ' . $livro -> titulo . '</span>';
            $respuesta.=  '<input type="hidden" name="titulo" value="' . $livro -> titulo . '">';
            $respuesta.=  'ISBN <span class="book_isbn">' . $livro -> isbn . '</span>';
            $respuesta.=  '<input type="hidden" name="isbn" value="' . $livro -> isbn . '">';
            $respuesta.=  "<input type='hidden' class='hdescrip' name='descricao' value='" . $livro -> descricao . "'>";
            if (strlen($desc) > 20) {
             //   $desc = substr($desc, 0, 20) . '...<a href="' . $livro -> getLinkPrevio() . '">Ver más</a>';
                $respuesta.=  "<input type='hidden' class='hdescrip' name='descricao' value='" . $livro -> descricao . "'>";
               $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            } else {
                $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
            }

            $respuesta.=  'Publicado el<span class="book_publication">' . $livro -> ano . '</span>';
            $respuesta.=  '<input type="hidden" name="ano" value="' . $livro -> ano. '">';
           // $respuesta.=  'Editora <span class="book_editora">' . $livro -> getEditora() . '</span>';
           // $respuesta.=  '<input type="hidden" name="editora" value="' . $livro -> getEditora() . '">';
            $respuesta.=  'Paginas <span class="book_paginas">' . $livro -> paginas . '</span>';
            $respuesta.=  '<input type="hidden" name="paginas" value="' . $livro -> paginas . '">';
          //  $respuesta.=  "<input type='hidden' class='book_moreinfo_link' name='linkprevio' value='". $livro -> getLinkPrevio() ."'";
          //  $respuesta.=  '<span class="book_moreinfo"><a href="' . $livro -> getLinkPrevio() . '">Aquí</a></span>';
            $cantidadautores=count($livro->getAutores());
            echo $cantidadautores."estooooooooooooo";
            if($cantidadautores>0){
                foreach ($livro->getAutores() as $autor ) {
                    $respuesta.=  "<input type='hidden' name='autores[]' class='livro_autor_item' value='".$autor->nome."'>";
                }
            }

            $respuesta.=  '<hr>';

            $respuesta.=  '</div>';


        echo $respuesta;
?>
Como esta o estado do seu livro
<select name="estadolivro">
					<option value="1">Bom</option>
					<option value="2">Mais ou menos</option>
					<option value="3">Ruim</option>

				</select>

<input type="submit" value="Confirmar">
<input name="_token" type="hidden" value="<?php echo csrf_token() ?>"/>
</form>
<?php
    if(isset($erro)){
        echo "<h1>Um erro aconteceu e nao foi possivel cadastrar</h1>";
    }
?>
