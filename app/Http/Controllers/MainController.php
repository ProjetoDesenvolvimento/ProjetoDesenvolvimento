<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Usuario;
class MainController extends Controller
{
    public function __construct() {

    }

    public function index() {
       /* $use=new Usuario();
        $use->id =2;
        $use->nome ="fran";
        $use->email ="javiercoulon@gmail.com";
        $use->remember_token="";
        $use->senha=bcrypt("una");
        $use->save();*/
        return view("main.index")->with("user", session()->get("user_data"));
    }

}
