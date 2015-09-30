<?php

namespace App\Http\Controllers;

require_once app_path().'/Models/Libro.php';
require_once app_path().'/Models/User.php';
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Models\framework\GestorLibros;
use App\Models\Livro;
use App\Models\User;
use Session;

class LivrosController extends Controller
{


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function tenho($id=0)
    {
          //$id = $request->input("id");
         $gestor = new GestorLibros();
         $livro = $gestor -> getBooksByID($id);
         return View::make('livros.tenho',
         array('livro' => $livro));
    }

    public function cadastrarLivroUsuario(Request $request)
    {

        $livro = new Livro();
        $id = $request->input("id");
        $isbn = $request->input("isbn");
        $titulo = $request->input("titulo");
        $autores = $request->input("autores");
        $descripcion = $request->input("descripcion");
        $datapublica = $request->input("anopubli");
        $paginas = $request->input("paginas");
        $editora = $request->input("editora");
        $linkPrevio = $request->input("linkprevio");
        $imageLink = $request->input("imagenlink");
        $estado=$request->input("estadolivro");

        $username=Session::get('user', function() { return 'chesco'; });
        $user=new User();
        $user->setIdusuario($username);

        $id= isset($id)?$id:'0';
        $isbn= isset($isbn)?$isbn:'';
        $titulo= isset($titulo)?$titulo:"";
        $paginas= isset($paginas) and strlen($paginas)>0?$paginas:0;
        $estado=isset($estado) and strlen($estado)>0?$estado:0;
        $datapublica= (isset($datapublica) and strlen($datapublica))>0?$datapublica:2015;
        echo "data publica".$datapublica.strlen($datapublica);

        $livro -> setId($id);
        $livro -> setIsbn($isbn);
        $livro -> setTitulo($titulo);
        $livro -> setDescripcion($descripcion);
        $livro -> setImageLink($imageLink);
        $livro -> setDataPublica($datapublica);
        $livro -> setPaginas($paginas);
        $livro -> setEditora($editora);
        $livro -> setLinkPrevio($linkPrevio);
        $livro -> setEstado($estado);
        $livro ->setDono($user);

        if($autores){
            foreach ($autores as $autor) {
                $livro -> addAutorWithName($autor);
            }
        }

        $gestor = new GestorLibros();
        if($gestor -> cadastrarLivro($livro)){
            return View::make('livros.cadastrolusuccess');
        }else{
            return View::make('livros.tenho',
                array('livro' => $livro,'erro'=>'si'));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //listado de livros

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function cadastro()
    {
        return View::make("livros.cadastro");
    }

    public function testasinc(){
        $vari=new GestorLibros();
        return "llegue";
    }

    public function obterfeed($startindex=0,$limit=10){
        //obter o usuario a partir da sessao
        $username=Session::get('user', function() { return 'chesco'; });
        $user=new User();
        $user->setIdusuario($username);
         $gestor = new GestorLibros();
         $livros = $gestor ->getBooksToFeed($user,$startindex,$limit);

         return View::make('livros.feed',
         array('livrosresult' => $livros,'start'=>$startindex,'limit'=>$limit));

    }
    public function verdato($type,$criteria){
        $type = isset($type) ? $type : "isbn";
        $data = isset($criteria) ? $criteria : "";
        $ini = isset($ini) ? $ini : 0;//inicio, offset
        $quan = isset($quan) ? $quan : 10;//quantidade, limit
        echo $type.$data;
        $respuesta="";
        //echo "datoos ".$type.$data;


        $gestor = new GestorLibros();

        switch ($type) {
            case 'isbn' :
                //	echo "finnn";
                $libros = $gestor -> searchBooksByISBN($data);

                break;

            case 'title' :
                $libros = $gestor -> searchBooksByTitle($data);
                break;

            case 'description' :
                $libros = $gestor -> searchBooksByDescription($data);
                break;
                    case 'year' :
                $libros = $gestor -> searchBooksByAllCriteria($data);
                break;

            case 'editor' :
                $libros = $gestor -> searchBooksByAllCriteria($data);
                break;
            case 'feed':
                $user=new User();
                $user->setIdusuario('');
                $libros = $gestor -> getBooksToFeed($user,$ini,$quan);
                break;

            default :
                break;
        }

        foreach ($libros as $livro) {
            //	echo "nada";
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

            $respuesta.=  '<hr>';

            $respuesta.=  '</div>';

            //echo "<option>" . $libro -> getIsbn().'</option>';
        }
            $respuesta.=  "<script>addHandlingToPosibilities();</script>";
            return $respuesta;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function cadastrarlivro(Request $request)
    {


         $livro = new Livro();
        $id = $request->input("id");
        $isbn = $request->input("isbn");
        $titulo = $request->input("titulo");
        $autores = $request->input("autores");
        $descripcion = $request->input("descripcion");
        $datapublica = $request->input("anopubli");
        $paginas = $request->input("paginas");
        $editora = $request->input("editora");
        $linkPrevio = $request->input("linkprevio");
        $authorscount;
        $imageLink = $request->input("imagenlink");
        $estado=$request->input("estadolivro");

        $idusuario="ejemplocualquiera2";
        $user=new User();
        $user->setIdusuario($idusuario);
            $id= isset($id)?$id:'0';
        $isbn= isset($isbn)?$isbn:'';
        $titulo= isset($titulo)?$titulo:"";
        $paginas= isset($paginas) and strlen($paginas)>0?$paginas:0;
        $estado=isset($estado) and strlen($estado)>0?$estado:0;
        $datapublica= (isset($datapublica) and strlen($datapublica))>0?$datapublica:2015;
        echo "data publica".$datapublica.strlen($datapublica);

        $livro -> setId($id);
        $livro -> setIsbn($isbn);
        $livro -> setTitulo($titulo);
        $livro -> setDescripcion($descripcion);
        $livro -> setImageLink($imageLink);
        $livro -> setDataPublica($datapublica);
        $livro -> setPaginas($paginas);
        $livro -> setEditora($editora);
        $livro -> setLinkPrevio($linkPrevio);
        $livro -> setEstado($estado);
        $livro ->setDono($user);


    if($autores){
        foreach ($autores as $autor) {
            $livro -> addAutorWithName($autor);
        }
        }

        $gestor = new GestorLibros();
        if($gestor -> cadastrarLivro($livro)){
            echo "Proceso terminado";
        };
        return "feliz fin";

    }



}
