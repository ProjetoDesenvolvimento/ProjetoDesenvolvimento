<?php

namespace App;
use App\Autor;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    //
    protected $table = 'livro';
   var  $autors=array();

   function setAutores($autors){
    $this->autors=$autors;
   }

   function addAutor($autor){
    array_push($this->autors,$autor);
   }

    function getAutores(){
        return $this->autors;
    }

}
