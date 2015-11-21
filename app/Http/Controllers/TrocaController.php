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
        echo  print_r(session()->get('user'),true);
    }

    /**
    *   esta funcao obtem as trocas do usuario logado atualmente e que estejam ativas.
    */
    public function getMinhasTrocas(){
         $user = Auth::user();
         $solicitudesresp=array();
         $meuslivros=LivroUsuario::select("id")->where("usuario_id","=",$user->id)->where("estado","=",1)->get();//obter os livros do usuario atual
         $meuslivrosarray=array();
         foreach($meuslivros as $liv){
            array_push($meuslivrosarray,$liv->id);

          }
          $solicitacaostroca = Troca::whereIn('solicitacao_A',$meuslivrosarray)->where("estado","=",1)->get();//obter as solicitudes de troca a partir dos livros do usuario
          foreach($solicitacaostroca as $solicitude){
            $usuario = Usuario::where("id","=",$solicitude->idsolicitante)->first();
            $livro=Livro::where("id","=",$solicitude->solicitacao_A)->first();
            array_push($solicitudesresp,array("object"=>$solicitude,"userdata"=>$usuario,"livrodetail"=>$livro));
          }
         return view("trocas.minhas" ,array("solicitudesresp"=>$solicitudesresp));

    }

    /**
    *   aceitar troca dum usuario, receve o id da troca
    */
     public function aceitarTroca($troca_id)
    {
        //redirect to select livro usuario
          $troca= Troca::where('id',"=",$troca_id)->first();//verificar se a troca existe
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
                ->get();//obtemos os livros os quais o usuario atual pode selecionar do outro usuario.

            return view("trocas.aceitado_step1",array("troca"=>$troca,"usuario"=>$usuario,"livros"=>$livros));

        }

    }

    /**
    *   esta funcao es a segunda parte do aceitarTroca, nesta parte obtemos a troca e o livro e verificamos para confirmar
    */
     public function confirmarTroca($troca_id,$livro_id)//livro seleccionado
    {

            if (Auth::check()){
                $user = Auth::user();
            }

        $troca= Troca::where('id',"=",$troca_id)->first();//obtemos a troca  para verificar se existe
        if($troca)
        {
            $usuario=Usuario::where("id","=",$troca->idsolicitante)->first();//obter o usuario que solicita
            if (empty($usuario)) {
                echo "Usuario nao existe";
                return;
            }

            $livro = LivroUsuario::where("usuario_id","!=", $user->id)->where("livro_id","=", $livro_id)->
            where("usuario_id","=",$troca->idsolicitante)->where("estado","<", "3")->first();//obtemos o livro verificando que seja do usuario, o livro e em estado disponivel
            if($livro){
                $troca->solicitacao_B=$livro->livro_id;
                $troca->estado=3;//aceitado
                $troca->save();//salvamos
                $livro->usuario_id=$user->id;
                $livro->save();//trocamos o dono do livro para que seja do usuario atual
                $livrodado=LivroUsuario::where("livro_id","=", $troca->solicitacao_A)->first();//obtemos nosso livro solicitado
                $livrodado->usuario_id=$troca->idsolicitante;//damos nosso livro par o outro usuario
                $livrodado->save();//salvamos
                //notificamos
                $notificacao = new Notification();
                $notificacao->texto = "O usuário ".Auth::user()->nome." aceito a troca de seu livro ";
                $notificacao->tipo = 2;//informativo
                $notificacao->emailorigen =  Auth::user()->email;
                $notificacao->emailobjeti = $usuario->email;
                $notificacao->estado = 1;
                $notificacao->save();
                return view("trocas.aceitadosuccess");
            }else{
                return "livro nao encontrado";
            }

        }

    }
    /**
    *   rejeitar alguma troca
    */
    public function rejeitarTroca($troca_id)
    {
        $troca= Troca::where('id',"=",$troca_id)->first();
        if($troca)
        {
            $troca->estado=2;//rejeitado
            $troca->save();
             return view("trocas.rejeitadosuccess");

        }else{
            return "Nada feito";
        }
    }

}
