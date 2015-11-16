<?php

namespace App\Http\Controllers;

use App\Usuario;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Config;
use App\Models\framework\GestorUsuarios;
class AuthController extends Controller
{
    public function getLogin() {
        $gestor=new GestorUsuarios();
        $linkurl=$gestor->getFacebookLoginURLforLogin();
        return view("auth.login",array("title"=>"Login","loginUrl"=>$linkurl));
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

      function postLoginFromFacebook()
    {//file:///var/www/html/trocalivro/books/app/Http/Controllers/Auth/AuthController.php

         $gestor=new GestorUsuarios();
         $resp=$gestor->loginUsuarioFromFacebook();
         if($resp!=null){
            $goreset=$resp["goreset"];
            $usuario=$resp["usuario"];
             if($goreset==1){
                return view('usuario.resetpassword')->with('usuario', $usuario);
             }else{
                Auth::login($usuario);
              session()->put("usuariologeado","SIM" );
              return redirect()->intended('/');
             }
         }else{
         session()->put("usuariologeado","nao" );
         return redirect()->intended('login');

         }

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
