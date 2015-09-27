<?php

namespace App\Models;
require_once 'Autor.php';
require_once 'User.php';
//requiere de un autor
/**
 * classe Livro
 *
 * Esta é a classe base dos livros, tem propriedades a utilizar em diferentes situações.
 *
 * @author Francisco Coulon
 */
class Livro {
private $id;
//identificador único
private $isbn;
//código isbn
private $titulo;
//título pelo cual as pessoas conhecen o livro
private $autores;
//um arranjo de tipo Author
private $descripcion;
// A descriçao do livro
private $datapublica;
// A data de publicação do livro
private $paginas;
// as paginas, quantidade
private $editora;
// a editora encarregada da publicação
private $linkPrevio;
//um link para google books, para o usuario ver mais detalhes do livro
private $authorscount;
//quantidade de authores, não é muito utilizado
private $imageLink;
//o link da imagen usada pelo livro

private $dono;

function setDono($dono) { $this->dono = $dono; }
function getDono() { return $this->dono; }

private $estado;

		  function __construct() {
			 $this->estado=1;

		  }
function getEstado(){
	return $this->estado;
}
function setEstado($estado){
	 $this->estado=$estado;
}
/**
 * @param $imageLink la url da imagem
 */
function setImageLink($imageLink) { $this->imageLink=$imageLink;
}
/**
 * Retorna o link da imagem
 */
function getImageLink() {
return $this->imageLink;
}
/**
 * @param $id identificador do livro
 * */
function setId($id) { $this->id=$id;
}
/**
 * Retorna identificador do livro
 * */
function getId() {
return $this->id;
}
/**
 * @param $isbn o codigo isbn do livro
 * */
function setIsbn($isbn) { $this->isbn=$isbn;
}
/**
 *  Retorna o codigo isbn do livro
 * */
function getIsbn() {
return $this->isbn;
}
/**
 * @param $titulo o titulo do livro
 * */
function setTitulo($titulo) { $this->titulo=$titulo;
}
/**
 * Retorna  o titulo do livro
 * */
function getTitulo() {
return $this->titulo;
}
/**
 * @param $autores o/s autor/es do livro
 * */
function setAutores($autores) { $this->autores=$autores;
}
/**
 * Obter o/s autor/es do livro
 * */
function getAutores() {
return $this->autores;
}
/**
 * @param $descripcion a descrição do livro
 * */
function setDescripcion($descripcion) { $this->descripcion=$descripcion;
}
/**
 * obter a descrição do livro
 * */
function getDescripcion() {
return $this->descripcion;
}
/**
 * @param $datapublica a data de publicação  do livro
 * */
function setDatapublica($datapublica) { $this->datapublica=$datapublica;
}
/**
 * obter a data de publicação  do livro
 * */
function getDatapublica() {
return $this->datapublica;
}
/**
 * @param $paginas a quantidade de paginas  do livro
 * */
function setPaginas($paginas) { $this->paginas=$paginas;
}
/**
 * obter a quantidade de paginas  do livro
 * */
function getPaginas() {
return $this->paginas;
}
/**
 * @param $editora a editora   do livro
 * */
function setEditora($editora) { $this->editora=$editora;
}
/**
 * Retorna a editora   do livro
 * */
function getEditora() {
return $this->editora;
}
/**
 * @param $linkPrevio o link previsualização  do livro
 * */
function setLinkPrevio($linkPrevio) { $this->linkPrevio=$linkPrevio;
}
/**
 *  obter o link previsualização  do livro
 * */
function getLinkPrevio() {
return $this->linkPrevio;
}
/**
 * @param $autor adicionar um novo autor do livro
 * */
function addAutor($autor) {
if(!isset($this->authorscount)) {
$this->authorscount=0;
}

$this->authorscount+=1;
if(!isset($this->autores)) {
$this->autores=array();
}
echo "un autor agregado";
array_push($this->autores,$autor);
}

function addAutorWithName($autorname) {
	$autor=new Autor();
	$autor->setNome($autorname);
if(!isset($this->authorscount)) {
$this->authorscount=0;
}
$this->authorscount+=1;
if(!isset($this->autores)) {
$this->autores=array();
}
echo "un autor agregado v2";
array_push($this->autores,$autor);
}
/**
 * Obter uma apresentação do objecto em formato texto
 */
function toString() {
return 'id'.$this->id.' isbn '.$this->isbn.' titulo '.$this->titulo.' descricao '.$this->descripcion.' link previ '.$this->linkPrevio;
}
}
/**
 * Fim da clase Livro
 */
?>
