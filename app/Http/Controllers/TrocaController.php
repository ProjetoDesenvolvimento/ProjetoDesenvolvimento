<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Troca;
use App\Usuario;
use App\LivroUsuario;
use App\Livro;
use App\Notification;
use Auth;

class TrocaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return "";
    }

    /**
     * Formulario de view do usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTrocaLivroForm() {
        echo "aqui";
        echo  print_r(session()->get('user'),true);
    }

    public function getMinhasTrocas(){
     $user = Auth::user();
     $solicitudesresp=array();
    $meuslivros=LivroUsuario::select("id")->where("usuario_id","=",$user->id)->where("estado","=",1)->get();
    $meuslivrosarray=array();
    foreach($meuslivros as $liv){
            array_push($meuslivrosarray,$liv->id);

    }
   // var_dump($meuslivrosarray);
      $solicitacaostroca = Troca::whereIn('solicitacao_A',$meuslivrosarray)->where("estado","=",1)->get();
    // var_dump($solicitacaostroca);
      foreach($solicitacaostroca as $solicitude){
        $usuario = Usuario::where("id","=",$solicitude->idsolicitante)->first();
        array_push($solicitudesresp,array("object"=>$solicitude,"userdata"=>$usuario));
      }
     //   echo var_dump($solicitacaostroca);
     return view("trocas.minhas" ,array("solicitudesresp"=>$solicitudesresp));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     public function aceitarTroca($troca_id)
    {
        //redirect to select livro usuario
          $troca= Troca::where('id',"=",$troca_id)->first();
        if($troca)
        {
        $usuario=Usuario::where("id","=",$troca->idsolicitante)->first();//obter o usuario que solicita
        if (empty($usuario)) {
            echo "Usuario nao existe";
            return;
        }

        $livros = LivroUsuario::select('livro.*', 'livrousuario.id as livrousuario_id', 'usuario.nome as usuario_nome')
            ->join("livro","livro.id", "=", "livrousuario.livro_id")
            ->join("usuario", "usuario.id","=","livrousuario.usuario_id")
            ->where("usuario.id","=", $usuario->id)
            ->where("livrousuario.estado","<", "3")
            ->get();

        return view("trocas.aceitado_step1",array("troca"=>$troca,"usuario"=>$usuario,"livros"=>$livros));
        //echo "aceitado ".$troca_id;

        }

    }


     public function confirmarTroca($troca_id,$livro_id)//livro seleccionado
    {

            if (Auth::check()){
            $user = Auth::user();
        }
        //redirect to select livro usuario
        $troca= Troca::where('id',"=",$troca_id)->first();
        if($troca)
        {
        $usuario=Usuario::where("id","=",$troca->idsolicitante)->first();//obter o usuario que solicita
        if (empty($usuario)) {
            echo "Usuario nao existe";
            return;
        }

        $livro = LivroUsuario::where("usuario_id","!=", $user->id)->where("livro_id","=", $livro_id)->
        where("usuario_id","=",$troca->idsolicitante)->where("estado","<", "3")->first();
        if($livro){
            $troca->solicitacao_B=$livro->livro_id;
            $troca->estado=3;//aceitado
            $troca->save();


            $livro->usuario_id=$user->id;
            $livro->save();
            $livrodado=LivroUsuario::where("livro_id","=", $troca->solicitacao_A)->first();
            $livrodado->usuario_id=$troca->idsolicitante;
            $livrodado->save();

             $notificacao = new Notification();
            $notificacao->texto = "O usuário ".Auth::user()->nome." aceito a troca de seu livro ";
            $notificacao->tipo = 2;//informativo
            $notificacao->emailorigen =  Auth::user()->email;
            $notificacao->emailobjeti = $troca->idsolicitante;
            $notificacao->estado = 1;
            $notificacao->save();
            return view("trocas.aceitadosuccess");
        }else{
            return "livro nao encontrado";
        }


        //echo "aceitado ".$troca_id;

        }

    }

    public function rejeitarTroca($troca_id)
    {
        $troca= Troca::where('id',"=",$troca_id)->first();
        if($troca)
        {

            $troca->estado=2;//rejeitado
            $troca->save();
             return view("trocas.rejeitadosuccess");

        }else{
            return "Naada feito";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
