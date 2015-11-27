<?php
namespace App\Http\Controllers;
use App\Livro;
use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\framework\GestorUsuarios;

class UsuarioController extends Controller
{

    private $usuario;

    public function __construct(Usuario $usuario){
        $this->usuario = $usuario;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCriar()
    {
        $gestor=new GestorUsuarios();
        $linkurl=$gestor->getFacebookLoginURLforLogin();

        return view("usuario.create", array("title"=>"Cadastro","loginUrl"=>$linkurl));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCriar(Request $request)
    {
        $usuario = new Usuario();
        $usuario->nome = $request->get("nome");
        $usuario->email = $request->get("email");
        $usuario->remember_token = "";
        $usuario->senha = bcrypt($request->get("senha"));
        $res = $usuario->save();
       // return "<script>parent.resultStore('$res')</script>";
        return redirect()->intended('login');

    }

    /*
    *   criar usaurio a partir dos dados no facebook
    */
    public function criarUsuarioFromFacebook(){
         $gestor=new GestorUsuarios();
         $usuario=$gestor->criarUsuarioFromFacebook();
         if($usuario!=null){
            return view('usuario.resetpassword')->with('usuario', $usuario);
         }else{
             return redirect()->intended('login');
         }

    }

    public function resetPassword(Request $request){

        $usuario2=new Usuario();
        $usuario2 = Usuario::where('id', '=', $request->get("id"))->first();
        echo $request->get("senha")."esta essss";
        $senha= bcrypt($request->get("senha"));
        //var_dump($usuario2);
        $usuario2->senha =$senha;
        $usuario2->save();
       // return "completado";
        return redirect()->intended('login');
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
        $user = $this->usuario->find($id);
        return view('usuario.show')->with('usuario', $user);
    }

    public function getMeusDados() {

        // Meus livros
        $livro = new LivroController(new Livro());
        $meusLivros = $livro->meusLivros();
        // Minhas trocas
        $troca = new TrocaController();
        $solicitacoes = $troca->minhasSolicitacoes();
        //
        $minhasTrocas = $troca->minhasTrocas();

        return view("usuario.meusDados", array("solicitacoes"=>$solicitacoes,"trocas"=>$minhasTrocas, "livros"=>$meusLivros));

    }
}
