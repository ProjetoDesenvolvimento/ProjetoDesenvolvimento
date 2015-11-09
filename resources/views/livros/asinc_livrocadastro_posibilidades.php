<?php
        $respuesta="";
        if(count($livrosarray)>0){

                    foreach ($livrosarray as $livro) {
                        $desc = $livro -> descricao;

                        $respuesta.= '<div id="posibilidad" class="posibilidad_item">';
                        $respuesta.=  '<input type="hidden" class="book_id" name="id" value="' . $livro -> idgb . '">';
                        $respuesta.=  '<img  height="60" width="60" src="' . $livro -> imagemurl . '" />';
                        $respuesta.=  "<input type='hidden' id='book_imglink' class='book_img_link' value='".$livro -> imagemurl."'>";
                        $respuesta.=  '<span class="book_title"> ' . $livro -> titulo. '</span>';
                        $respuesta.=  '<br>ISBN <span class="book_isbn">' . $livro -> isbn . '</span><br>';
                        if (strlen($desc) > 100) {
                          //  $desc = substr($desc, 0, 20) . '...<a href="' . $livro -> getLinkPrevio() . '">Ver más</a>';
                            $respuesta.=  "<input type='hidden' class='hdescrip' name='hddescrip' value='" . $livro -> descricao . "'>";
                            $respuesta.=  'Descriçao <span class="book_description">' . substr($desc, 0, 100) . '...</span>';
                        } else {
                            $respuesta.=  'Descriçao <span class="book_description">' . $desc . '</span>';
                        }

                        $respuesta.=  '<br>Publicacao: <span class="book_publication">' . $livro -> ano . '</span>';
                        $respuesta.=  '<br>Paginas <span class="book_paginas">' . $livro -> paginas . '</span>';

                        if($livro->getAutores()){
                            foreach ($livro->getAutores() as $autor ) {
                                $respuesta.=  "<input type='hidden' class='livro_autor_item' value='".$autor->nome."'>";
                            }
                        }

                        $respuesta.=  '<hr>';
                        $respuesta.=  '</div>';
                }
                    $respuesta.=  "<script>addHandlingToPosibilities();</script>";

            }
            else{
                $respuesta="<strong>Nao encontramos coincidencias</strong>";
            }
            echo $respuesta;

?>
