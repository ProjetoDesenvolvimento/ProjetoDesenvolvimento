<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;
use View;
use Auth;
use DB;
class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        //
        echo "a";
    }

    /**
     * Formulario de view do usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserNotifications() {
        $user = Auth::user();
        //tipo 1 notifications estado 1 é ativo
        if(Notification::where('emailobjeti', '=', $user->email)->exists()){//tudas as notificacoes do usuario
            $notifications=Notification::where('emailobjeti', '=', $user->email)->where('estado', '=', 1)->get();
            return View::make('usuario.notifications.rendernotifications', array('notifications' => $notifications));
        }else{
            //echo "nao existo";
        }

    }

    public function getUserLastNotifications() {

         $user = Auth::user();
         $usersname=array();
         //echo var_dump($user);
        //tipo 1 notifications estado 1 é ativo
        if(Notification::where('emailobjeti', '=', $user->email)->where('estado', '=', 1)->exists()){
            $notifications=Notification::where('emailobjeti', '=', $user->email)->where('estado', '=', 1)->get();
            $notificationsresp=array();
            foreach($notifications as $notif){
                $notif->estado=2;
                if($notif->tipo==1){
                        $useraux=  DB::table('usuario')->select('nome')->where('email', "=", $notif->emailorigen)->first();
                        array_push($notificationsresp,array("object"=>$notif,"sourcedata"=>$useraux->nome));
                       /* if($useraux){
                            array_push($usersname,$useraux->nome);
                        }else{
                               array_push($usersname,"DESCONOCIDO!");
                        }*/
                }else{
                    array_push($notificationsresp,array("object"=>$notif,"sourcedata"=>0));
                }



                $notif->save();
            }
            return View::make('usuario.notifications.rendernotifications', array('notificationsresp' => $notificationsresp));
        }else{
            //echo "nao existo";
        }

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
