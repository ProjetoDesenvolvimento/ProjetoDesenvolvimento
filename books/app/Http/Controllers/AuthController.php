<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function getLogin() {
        return view("auth.login");
    }

    public function postLogin(Request $request) {
        $email = $request->get("email");
        $senha = $request->get("senha");
        if (empty($email) ||  empty($senha)){
            Redirect::to('auth/login')->with('message', 'Login Failed');
        }

        $usuario = Usuario::whereRaw('email = ? and senha = ?',[$email, $senha])->first();

        if(!$usuario){
            Route::redirect("auth/login");
        }
        $session_data = array(
            "id" => $usuario->id,
            "email" => $usuario->email
        );
        session()->put("user_data", $session_data);

        return Redirect::to('/');
    }
}
