<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Livro;
use App\Autor;
use App\Usuario;
use App\LivroAutor;
use App\LivroUsuario;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\PostDec;
use App\Models\framework\GestorLibros;
use View;
//use App\Models\Livro;

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
        return view('livros.index', ['livros' => $livros]);
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

     private function getBookFromRequest(Request $request){
          $livro = new Livro();
         $livro->isbn=$request->get("isbn");
         $livro->idgb=$request->get("idgb", "nada2");
         $livro->titulo = $request->get("titulo");
         $livro->descricao = $request->get("descricao");
         $livro->ano = $request->get("ano");
         $livro->paginas = $request->get("paginas");
         $livro->imagemurl = $request->get("imageurl","#");
         $livro->created_at=date('Y-m-d G:i:s');
         $livro->updated_at=date('Y-m-d G:i:s');

        return $livro;
     }
    public function store(Request $request)
    {

        $gestor=new GestorLibros();
        $livro = DB::table('livro')->select('id', 'isbn','idgb','titulo','descricao','ano','paginas','imagemurl')
         ->where('idgb', $request->get("idgb", "nada2"))->first();
         if(!$livro){   //si no existe el livro
       //  echo "entreee para livro <br>";//.var_dump($request);;

         $livro=$this->getBookFromRequest($request);

         $autores=$request->get("autores");
         $gestor->cadastrarLivro($livro);
         $gestor->cadastrarAutoresLivro($autores,$livro);//AUTORES LIVROS CADASTRO
       //  echo "<hr>".var_dump($livro)."<hr> con el id de ".$livro->id;

    }

           $user=Usuario::where('email','=','chescojavier')->first();
           if(!$user){

                $user=new Usuario();
                $user->email="chescojavier";
                $user->id=1;
           }
     //  echo  var_dump($livro);
          // $gestor->cadastrarUsuarioLivro($user,$livro);
            if(!LivroUsuario::where('usuario_id', '=', $user->id)->where('livro_id', '=', $livro->id)->exists()){

                $lu=new LivroUsuario();
                $lu->usuario_id=1;
                $lu->livro_id=$livro->id;
              //  echo $lu->livro_id.$livro->id;
                $lu->estado=$request->get("estadolivro");;
                $lu->save();

            }else{
              //  echo "el usuario ya lo tiene";
            }
return View::make('livros.cadastrolivrosuceso', array('livro' => $livro));
}


    public function cadastrarLivroUsuario(Request $request)
    {


        $gestor=new GestorLibros();
        $livro = DB::table('livro')->select('id', 'isbn','idgb','titulo','descricao','ano','paginas','imagemurl')
         ->where('idgb', $request->get("idgb", "nada2"))->first();
         if(!$livro){   //si no existe el livro
       //  echo "entreee para livro <br>";//.var_dump($request);;

         $livro=$this->getBookFromRequest($request);

         $autores=$request->get("autores");
         $gestor->cadastrarLivro($livro);
         $gestor->cadastrarAutoresLivro($autores,$livro);//AUTORES LIVROS CADASTRO
       //  echo "<hr>".var_dump($livro)."<hr> con el id de ".$livro->id;

    }

           $user=Usuario::where('email','=','chescojavier')->first();
           if(!$user){

                $user=new Usuario();
                $user->email="chescojavier";
                $user->id=1;
           }
     //  echo  var_dump($livro);
          // $gestor->cadastrarUsuarioLivro($user,$livro);
            if(!LivroUsuario::where('usuario_id', '=', $user->id)->where('livro_id', '=', $livro->id)->exists()){

                $lu=new LivroUsuario();
                $lu->usuario_id=1;
                $lu->livro_id=$livro->id;
              //  echo $lu->livro_id.$livro->id;
                $lu->estado=$request->get("estadolivro");;
                $lu->save();

            }else{
              //  echo "el usuario ya lo tiene";
            }

return View::make('livros.cadastrolusuccess', array('livro' => $livro));
    }

    public function verdato($type,$criteria){
        $type = isset($type) ? $type : "isbn";
        $data = isset($criteria) ? $criteria : "";
        $ini = isset($ini) ? $ini : 0;//inicio, offset
        $quan = isset($quan) ? $quan : 10;//quantidade, limit
        echo $type.$data;

        $livros=null;
        $livrosarray=array();
        $criteria_="";

        //echo "datoos ".$type.$data;
        switch ($type) {
            case 'isbn' :
                //	echo "finnn";

                $criteria_="isbn";

                break;

            case 'title' :

                $criteria_="titulo";
                break;

            case 'description' :

                $criteria_="descricao";
                break;

            default :
             $criteria_="idgb";
                break;
        }
            $livros=Livro::where($criteria_, 'LIKE', '%'.$criteria.'%')->take(10)->get();

            $nlivros=count($livros);

    if($nlivros>0){
        foreach($livros as $liv){
            array_push($livrosarray,$liv);
        }
    }
    if($nlivros<10){
                echo "menos de diez".$nlivros;
                $nlivros=10-$nlivros;

        $gestor = new GestorLibros();

        switch ($type) {
            case 'isbn' :
                //	echo "finnn";
                $libros = $gestor -> searchBooksByISBN($data);
                $crieteria="isbn";

                break;

            case 'title' :
                $libros = $gestor -> searchBooksByTitle($data);
                $criteria="titulo";
                break;

            case 'description' :
                $libros = $gestor -> searchBooksByDescription($data);
                $criteria="descricao";
                break;
                    case 'year' :
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

        }
      //  echo var_dump($libros);
        foreach ($libros as $livro) {
            array_push($livrosarray,$livro);
            echo "agregando";
        }

        return View::make('livros.asinc_livrocadastro_posibilidades', array('livrosarray' => $livrosarray));

    }


    public function obterfeed($startindex=0,$limit=10){
        //obter o usuario a partir da sessao
        $username=Session::get('user', function() { return 'chesco'; });
        $user=new Usuario();
        $user->email=$username;
         $gestor = new GestorLibros();
         $livrosarray=array();
         $livros=Livro::select('id', 'isbn','idgb',
         'titulo','descricao','ano','paginas','imagemurl')->skip($startindex*$limit)->take($limit)->get();
         foreach($livros as $liv){
            echo "<br>el id  es ".$liv->id." </br>";
            array_push($livrosarray,$liv);
         }

         $livros = $gestor ->getBooksToFeed($user,$startindex,$limit);

         foreach($livros as $liv){
            array_push($livrosarray,$liv);
         }


         return View::make('livros.feed',
              array('livrosresult' => $livrosarray,'start'=>$startindex,'limit'=>$limit));

    }

    public function tenho($idgb="",$id=0)
    {
    echo "el ide es ".$id;
          //$id = $request->input("id");
         $gestor = new GestorLibros();
         $livro = Livro::where("id","=",$id)->orWhere("idgb","=",$idgb)->select('id', 'isbn','idgb',
         'titulo','descricao','ano','paginas','imagemurl')->first();
         if(!$livro){
            $gestor -> maxResults=1;
            $gestor ->updateFilters();
            $livros=$gestor->searchGBBooksById($idgb);
            if(count($livros)>0){
                $livro=$livros[0];
            }
         }
         return View::make('livros.tenho', array('livro' => $livro));
    }
}
