<?php

namespace App\Http\Controllers;

use App\Usuario;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function getLogin() {
        return view("auth.login");
    }

    public function postLogin(Request $request)
    {
        $email = $request->get("email");
        $password = $request->get("senha");
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->intended('/');
        }
        return redirect()->intended('login');
    }

    public function postLogin2(Request $request) {
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Usuario::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}
