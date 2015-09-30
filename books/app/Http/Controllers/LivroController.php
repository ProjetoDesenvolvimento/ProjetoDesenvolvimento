<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Livro;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\PostDec;

class LivroController extends Controller
{

    private $livro;

    public function __construct(Livro $livro){
        $this->livro = $livro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livros = $this->livro->all();
        return view('livro.index', ['livros' => $livros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("livros.cadastro");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id          = $request->get("id");
        $isbn        = $request->get("isbn");
        $titulo      = $request->get("titulo");
        $autores     = $request->get("autores");
        $descricao   = $request->get("descricao");
        $datapublica = $request->get("anopubli");
        $paginas     = $request->get("paginas");
        $editora     = $request->get("editora");
        $linkPrevio  = $request->get("linkprevio");
        $imagemUrl   = $request->get("imagemurl");
        $estado      = $request->get("estadolivro");


        // Verificar no banco de dados, caso não exista, consultar no Google Books





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

        $livro = new Livro();
        $livro -> setId($id);
        $livro -> setIsbn($isbn);
        $livro -> setTitulo($titulo);
        $livro -> setDescripcion($descricao);
        $livro -> setImageLink($imagemUrl);
        $livro -> setDataPublica($datapublica);
        $livro -> setPaginas($paginas);
        $livro -> setEditora($editora);
        $livro -> setLinkPrevio($linkPrevio);
        $livro -> setEstado($estado);
        $livro -> setDono($user);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo "Livro!";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
