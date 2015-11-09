<?php

namespace App\Http\Controllers;

use App\Usuario;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Config;

class AuthController extends Controller
{
    public function getLogin() {
        return view("auth.login");
    }

    public function postLogin(Request $request)
    {//file:///var/www/html/trocalivro/books/app/Http/Controllers/Auth/AuthController.php

        $email = $request->get("email");
        $password = $request->get("senha");
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
         session()->put("usuariologeado","SIM" );

            return redirect()->intended('/');
        }
       // return redirect()->intended('/');
       session()->put("usuariologeado","nao" );
        return redirect()->intended('login');
       //echo "fatal".$email,$password;//bcrypt($password);
    }

    public function getLogout() {
        Auth::logout();
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
