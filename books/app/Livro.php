<?php

namespace App;
use App\Autor;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    //
    protected $table = 'livro';
    var  $authors=array();

    function setAutores($autors){
        $this->authors=$autors;
    }

    function addAutor($autor){
        array_push($this->authors,$autor);
    }

    function getAutores(){
        return $this->authors;
    }

}
