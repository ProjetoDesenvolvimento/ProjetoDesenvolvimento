<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HelloController extends  Controller
{
    /**
     *file:///var/www/html/livros/ProjetoDesenvolvimento/books/app/Http/Controllers/Hellow.php
 Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function hola()
    {
        return View::make('hello.hello');;
    }
}

?>
