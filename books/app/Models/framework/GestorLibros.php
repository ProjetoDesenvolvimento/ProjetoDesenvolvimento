<?php

namespace App\Models\framework;

require_once app_path().'/Libraries/Google/GoogleBooks/src/Google/autoload.php';
use Google_Client;
use Google_Service_Books;
use DB;
use App\Livro;
use App\Autor;
use App\Usuario;
use App\LivroAutor;
use App\LivroUsuario;
//require_once app_path().'/Models/Libro.php';
//require_once app_path().'/Models/db/Connection.php';
//require_once app_path().'/Models/User.php';

//use \App\Models\db\Connection;

/**
 *Nesta clase se faz a utilização da API de google Books, deixa tudo praticamente para ser utilizado num alto nivel de programação.
 * @author Francisco Coulon
 *
 */
class GestorLibros {

	var $service;
	//o objeto de Google Service, deve ser um Google_Service_Books
	var $fields;
	// indica os campos que vamos precisar na solicitude
	var $maxResults;
	//a quantidade maxima do livros na resposta
	var $startIndex;
	//o inicio de leitura das respostas
	private $fieldsString;
	/**
	 * Funçao construtora
	 *
	 * Nesta função, a ideia é inicializar os objetos principais da clase.
	 */
	function __construct() {
		$client = new Google_Client();
		$client->setApplicationName("Troca-livro");
		$client->setDeveloperKey("AIzaSyDsrOtruI3COBhB-7pxm5MlO55W-DyaJu8");

		$service1 = new Google_Service_Books($client);
		$this -> service = $service1;
		$this -> maxResults = 5;
		$this -> startIndex = 0;
		$this -> fields = "kind,items(id,volumeInfo/title,";
		$this -> fields .= "volumeInfo/authors,volumeInfo/pageCount,volumeInfo/publisher,volumeInfo/previewLink,";
		$this -> fields .= "volumeInfo/publishedDate,volumeInfo/description,volumeInfo/industryIdentifiers,volumeInfo/imageLinks)";
		$this->fieldsString=$this->fields;
		$this -> fields = array("fields" => $this -> fields, "maxResults" => $this -> maxResults, "startIndex" => $this -> startIndex);

	}

	function updateFilters() {
		$this -> fields = array("fields" => $this->fieldsString, "maxResults" => $this -> maxResults, "startIndex" => $this -> startIndex);
	}


	/**
	 * Esta função faz a pesquisa pelo isbn do livro no banco de dados
	 * @param $isbn, o codigo isbn do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchBooksByISBN($isbn) {

		$livros=array();

		if ($this -> maxResults > 0) {

			$extrabooks = $this -> searchGBBooksByISBN($isbn);
			if($extrabooks){
				foreach ($extrabooks as $livro) {
					array_push($livros, $livro);
				}
			}
		}

		return $livros;
	}



	/**
	 * Esta função faz a pesquisa utilizando multiples criterios, par exemplo, podería ser que o usuario precise de pesquiçar pelo isbn
	 * e o título do livro, os criterios de pesquiça vão variar, mas a função tem a funcionalidadde de adaptarse dependendo do tipo de
	 * solicitude. A seguir os códigos que precisa a funcão, tudo isto no banco de dados
	 * @param $type, o tipo de pesquiça que o cliente quer fazer.
	 * 		1 - pesquiça pelos criterios de titulo, isbn, , descrição
	 * 		2 - pesquiça pelos criterios de titulo, isbn, ,
	 * 		3 - pesquiça pelos criterios de , isbn, , descrição
	 * 		4 - pesquiça pelos criterios de , isbn, ,
	 * 		5 - pesquiça pelos criterios de titulo, , , descrição
	 * 		6 - pesquiça pelos criterios de titulo, , ,
	 * 		7 - pesquiça pelos criterios de , , , descrição

	 *  @param $criteria, o valor a pesquiçar
	 * @return Um arranjo de livros
	 *
	 */
	function searchBooksByMultipleCriteria($type, $criterio) {
		//echo "o criterio é".$isbn;
		$livros=array();
		if ($this -> maxResults > 0) {

			$extrabooks = $this -> searchGBBooksByMultipleCriteria($type,$criterio);
			foreach ($extrabooks as $livro) {
				array_push($livros, $livro);
			}
		}

		return $livros;
	}

	/**
	 * Esta função faz a pesquisa utilizando multiples criterios, par exemplo, podería ser que o usuario precise de pesquiçar pelo isbn
	 * e o título do livro, os criterios de pesquiça vão variar, mas a função tem a funcionalidadde de adaptarse dependendo do tipo de
	 * solicitude. A seguir os códigos que precisa a funcão
	 * @param $type, o tipo de pesquiça que o cliente quer fazer.
	 * 		1 - pesquiça pelos criterios de titulo, isbn, autor, descrição
	 * 		2 - pesquiça pelos criterios de titulo, isbn, autor
	 * 		3 - pesquiça pelos criterios de titulo, isbn, descrição
	 * 		4 - pesquiça pelos criterios de titulo, isbn
	 * 		5 - pesquiça pelos criterios de titulo, autor, descrição
	 * 		6 - pesquiça pelos criterios de titulo, autor
	 * 		7 - pesquiça pelos criterios de titulo,  descrição
	 * 		8 - pesquiça pelos criterios de titulo
	 * 		9 - pesquiça pelos criterios de  isbn, autor, descrição
	 * 		10 - pesquiça pelos criterios de isbn, autor
	 * 		11- pesquiça pelos criterios de  isbn,  descrição
	 * 		12 - pesquiça pelos criterios de isbn
	 * 		13 - pesquiça pelos criterios de autor, descrição
	 * 		14 - pesquiça pelos criterios de autor
	 * 		15 - pesquiça pelos criterios de descrição
	 *  @param $criteria, o valor a pesquiçar
	 * @return Um arranjo de livros
	 *
	 */
	function searchGBBooksByMultipleCriteria($type, $criterio) {
		$criterio = $this -> getCleanedCriteria($criterio);
		$query = "https://www.googleapis.com/books/v1/volumes?q=";
		switch ($type) {
			case 1 :
				$query .= 'isbn:' . $criterio . '&inauthor:' . $criterio . '&intitle:' . $criterio . '&subject:' . $criterio;
				break;
			case 2 :
				$query .= 'isbn:' . $criterio . '&inauthor:' . $criterio . '&intitle:' . $criterio;
				break;
			case 3 :
				$query .= 'isbn:' . $criterio . '&inauthor:' . $criterio . '&subject:' . $criterio;
				break;
			case 4 :
				$query .= 'isbn:' . $criterio . '&inauthor:' . $criterio;
				break;
			case 5 :
				$query .= 'isbn:' . $criterio . '&intitle:' . $criterio . '&subject:' . $criterio;
				break;
			case 6 :
				$query .= 'isbn:' . $criterio . '&intitle:' . $criterio;
				break;
			case 7 :
				$query .= 'isbn:' . $criterio . '&subject:' . $criterio;
				break;
			case 8 :
				$query .= 'isbn:' . $criterio;
				break;
			case 9 :
				$query .= 'inauthor:' . $criterio . '&intitle:' . $criterio . '&subject:' . $criterio;
				break;
			case 10 :
				$query .= 'inauthor:' . $criterio . '&intitle:' . $criterio;
				break;
			case 11 :
				$query .= 'inauthor:' . $criterio . '&subject:' . $criterio;
				break;
			case 12 :
				$query .= 'inauthor:' . $criterio;
				break;
			case 13 :
				$query .= 'intitle:' . $criterio . '&subject:' . $criterio;
				break;
			case 14 :
				$query .= 'intitle:' . $criterio;
				break;
			case 15 :
				$query .= 'subject:' . $criterio;
				break;

			default :
				break;
		}
		$page = file_get_contents($query);
		$data = json_decode($page, true);
		$values_ = $data['items'];

		return $this -> getBooksFromResult($values_);
	}


	/**
	 * Esta função faz a pesquisa pelo title do livro no banco de dados
	 * @param $isbn, o codigo isbn do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchBooksByTitle($titulo) {
		$livros=array();
		if ($this -> maxResults > 0) {

			$extrabooks = $this -> searchGBBooksByTitle($titulo);
			foreach ($extrabooks as $livro) {
				array_push($livros, $livro);
			}
		}

		return $livros;
	}

	function getBooksByID($id) {
		//echo "o criterio é".$isbn;

		$livros=array();
		$extrabooks = $this -> searchGBBooksById($id);
		foreach ($extrabooks as $livro) {
			return $livro;

		}


		return null;
	}

	function searchGBBooksById($id) {
		$subject = $this -> getCleanedCriteria($id);
		$results = $this -> service -> volumes -> listVolumes('id:' . $id, $this -> fields);
		$values_ = $results['items'];

		$books= $this -> getBooksFromResult($values_);

		return $books;
	}

	function searchGBBooksByISBN($isbn) {
		$subject = $this -> getCleanedCriteria($isbn);
		$results = $this -> service -> volumes -> listVolumes('isbn:' . $isbn, $this -> fields);
		$values_ = $results['items'];

		$books= $this -> getBooksFromResult($values_);

		return $books;
	}

	/**
	 * Esta função faz a pesquisa pelo titulo do livro
	 * @param $titulo, o titulo do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchGBBooksByTitle($title) {
		$title = $this -> getCleanedCriteria($title);
		$results = $this -> service -> volumes -> listVolumes('intitle:' . $title, $this -> fields);
		$values_ = $results['items'];

		return $this -> getBooksFromResult($values_);
	}


	/**
	 * Esta função faz a pesquisa pela descrição  do livro no banco de dados
	 * @param $subject, a descrição do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchBooksByDescription($subject) {
		$livros=array();
		if ($this -> maxResults > 0) {

			$extrabooks = $this -> searchGBBooksByDescription($subject);
			foreach ($extrabooks as $livro) {
				array_push($livros, $livro);
			}
		}

		return $livros;
	}
	/**
	 * Esta função faz a pesquisa pela descrição  do livro
	 * @param $subject, a descrição do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchGBBooksByDescription($subject) {
		$subject = $this -> getCleanedCriteria($subject);
		$results = $this -> service -> volumes -> listVolumes('subject:' . $subject, $this -> fields);
		$values_ = $results['items'];

		return $this -> getBooksFromResult($values_);
	}

	/**
	 * Esta função faz a pesquisa pelo author do livro
	 * @param $autor, o autor do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchBooksByAuthor($author) {
		$author = $this -> getCleanedCriteria($author);
		$results = $this -> service -> volumes -> listVolumes('inauthor:' . $author, $this -> fields);
		$values_ = $results['items'];
		//var_dump($values_);
		//echo "autorooro" .$author." ".gettype($this->fields);
		return $this -> getBooksFromResult($values_);
	}

	/**
	 * Esta função faz a pesquisa sem utilizar filtro nehum
	 * @param $all algum dado do livro
	 * @return Um arranjo de livros
	 *
	 */
	function searchBooksByAllCriteria($all) {
		//echo "o criterio é".$isbn;
		$livros=array();

		if ($this -> maxResults > 0) {

			$extrabooks = $this -> searchGBBooksByAllCriteria($all);
			foreach ($extrabooks as $livro) {
				array_push($livros, $livro);
			}
		}

		return $livros;
	}
	/**
	 * Esta função faz a pesquisa sem utilizar filtro nehum
	 * @param $all algum dado do livro
	 * @return Um arranjo de livros
	 *
	 */
	function searchGBBooksByAllCriteria($all) {
		$all = $this -> getCleanedCriteria($all);
		$results = $this -> service -> volumes -> listVolumes($all, $this -> fields);
		$values_ = $results['items'];

		return $this -> getBooksFromResult($values_);
	}

	/**
	 * Esta função se encarga de tranformar um objeto json, á um objeto Livro
	 * @return um novo objeto livro
	 */
	function getBooksFromResult($result) {
		$books = array();
		$values_ = $result;
		foreach ($values_ as $value) {
			$book = new Livro();
			$book -> titulo=$value['volumeInfo']['title'];

			$authors = $value['volumeInfo']['authors'];

			if(count($authors)>0){
				foreach ($authors as $author) {
					$au=new Autor();
					$au->nome=$author;
					$book -> addAutor($au);
				}
			}
			$book->idgb = ($value['id']);
			$book->paginas = ($value['volumeInfo']['pageCount']);
			$book->editora = ($value['volumeInfo']['publisher']);

			$book->linkPrevio = ($value['volumeInfo']['previewLink']);
			$book->ano = ($value['volumeInfo']['publishedDate']);
			$book->descricao = ($value['volumeInfo']['description']);
			if(isset($value['volumeInfo']['industryIdentifiers'])){
				$book->isbn = ($value['volumeInfo']['industryIdentifiers'][0]['identifier']);
			}
			$book -> imagemurl=($value['volumeInfo']['imageLinks']['thumbnail']);
			array_push($books, $book);
		}

		return $books;
	}

	/**
	 * Transforma uma cadena com espaços a uma cadena com os %20% correspondentes, para evitar erros  na solicitude Ex: olá mundo => olá%20%mundo
	 */
	function getCleanedCriteria($criteria) {
		return urlencode($criteria);
	}


	function getBooksToFeed($ini=0,$quan=10){

		$this->maxResults=$quan;
		$this->startIndex=$ini;
		$this->updateFilters();

		$livros=array();

		////echo count($livros);
		//echo " this max results ".$this->maxResults;
		if ($this -> maxResults > 0) {
			if(!isset($thisautor)){
				$thisautor="book";//obter el autor com mais livros
			}
			$extrabooks = $this -> searchGBBooksByAllCriteria($thisautor);
			//echo "quantidade ".count($extrabooks);
			foreach ($extrabooks as $livro) {
				array_push($livros, $livro);
			}
		}
		//echo count($livros);

		return $livros;
	}

	function cadastrarLivro($livro){

		if(!$livro){
			return false;
		}



		$data=array("isbn"=>$livro->isbn,"idgb"=>$livro->idgb,"titulo"=>$livro->titulo,
			"descricao"=>$livro->descricao,"ano"=>$livro->ano,"paginas"=>$livro->paginas,
			"imagemurl"=>$livro->imagemurl,"created_at"=>$livro->created_at,"updated_at"=>$livro->updated_at);
		$id= Livro::insertGetId($data);
		$livro->id=$id;

		$livro = Livro::where('id', $livro->id)->first();

		return $livro;

	}

	function cadastrarAutoresLivro($autores,$livro){
		//$autores//=$livro->getAutores();
		$au=array();
		foreach($autores as $autor){
			//echo "nome ".$autor;
			if( !Autor::where('nome', '=', $autor)->exists()){
				$a= new Autor();
				$a->nome=$autor;
				$a->save();
				$a= Autor::where('nome', '=', $autor)->first();

				if(!LivroAutor::where('autor_id', '=', $a->id)
					->where('livro_id', '=', $livro->id)->exists()){

					$la=new LivroAutor();
					$la->autor_id=$a->id;
					$la->livro_id=$livro->id;
					$la->save();

				}
			}
		}
		return true;

	}



}


?>
