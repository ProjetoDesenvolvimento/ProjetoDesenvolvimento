<?php

namespace App\Models\framework;

require_once app_path().'/Libraries/Google/GoogleBooks/src/Google/autoload.php';
use Google_Client;
use Google_Service_Books;
require_once app_path().'/Models/Libro.php';
require_once app_path().'/Models/db/Connection.php';
require_once app_path().'/Models/User.php';

use \App\Models\db\Connection;
use \App\Models\Livro;
use \App\Models\User;
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

	function getBooksFromDbQuery($db_con) {
		$livros=array();
		$count=0;

		while ($row = $db_con -> getResultsAssoc()) {//ver livros
			$book = new Livro();
			$book -> setId($row["id"]);
			$book -> setIsbn($row["isbn"]);
			$book -> setDescripcion($row["descripcao"]);
			$book -> setPaginas($row["paginas"]);
			$book -> setEditora($row["editora"]);
			$book -> setLinkPrevio($row["link"]);
			$book -> setImageLink($row["imgprev"]);
			$book -> setDatapublica($row["datapublica"]);
			$book -> setTitulo($row["titulo"]);
			$count++;
			array_push($livros, $book);
		}

		foreach ($livros as &$livro) {
		echo "viendo autor".$livro -> getId();
			$query = "select id,name from autor,livroautor where autor.id=livroautor.idautor and livroautor.idlivro='" . $livro -> getId() . "';";
			$db_con -> executeQuery($query);
			echo $query;
			while ($row = $db_con -> getResultsAssoc()) {//ver autores
				$livro -> addAutor($row["name"]);
			}
		}

		if ($count > 0) {
			$this -> maxResults = $this -> maxResults- $count;
			$this -> updateFilters();

		}
		return $livros;

	}

	/**
	 * Esta função faz a pesquisa pelo isbn do livro no banco de dados
	 * @param $isbn, o codigo isbn do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchBooksByISBN($isbn) {
		//echo "o criterio é".$isbn;
		$db_con = new Connection();
		$query = "SELECT * FROM livro
		 where isbn like '%" . $isbn . "%';";
		$db_con -> executeQuery($query);
		$livros=$this->getBooksFromDbQuery($db_con);

		if ($this -> maxResults > 0) {

			$extrabooks = $this -> searchGBBooksByISBN($isbn);
			//echo "entreeeeeeeeeeeeeeeeeeeeeeeeeee ni seeeeeeeeeeeeeeee";
            if($extrabooks){
			foreach ($extrabooks as $livro) {
				array_push($livros, $livro);
			}
			}
		}

		return $livros;
	}

	/**
	 * Esta função faz a pesquisa pelo isbn do livro
	 * @param $isbn, o codigo isbn do livro ou parte dele
	 * @return Um arranjo de livros
	 *
	 */
	function searchGBBooksByISBN($isbn) {
		echo "o criterio é".$isbn."maximo es ".$this->maxResults;
		$isbn = $this -> getCleanedCriteria($isbn);
		$results = $this -> service -> volumes -> listVolumes('isbn:' . $isbn, $this -> fields);
		$values_ = $results['items'];

		return $this -> getBooksFromResult($values_);
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
		$db_con = new Connection();
		$query = "SELECT id, isbn, descripcao, paginas, editora, link, imgprev,  datapublica, titulo FROM livro
		 where ";
		switch ($type) {
			case 1 :
				$query .= " isbn like '%" . $criterio . "%' or  titulo like '%" . $criterio . "%' or  descripcao like '%" . $criterio . "%' ";
				break;
			case 2 :
				$query .= " isbn like '%" . $criterio . "%' or  titulo like '%" . $criterio . "%'  ";
				break;
			case 3 :
				$query .= " isbn like '%" . $criterio . "%' or    descripcao like '%" . $criterio . "%' ";
				break;
			case 4 :
				$query .= " isbn like '%" . $criterio . "%'  ";
				break;
			case 5 :
				$query .= " titulo like '%" . $criterio . "%' or  descripcao like '%" . $criterio . "%' ";		break;
			case 6 :
					$query .= "   titulo like '%" . $criterio . "%'  ";
				break;
			case 7 :
					$query .= " descripcao like '%" . $criterio . "%' ";
				break;

			default :
				break;
		}
		$db_con -> executeQuery($query);
		$livros=$this->getBooksFromDbQuery($db_con);

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
		//echo "o criterio é".$isbn;
		$db_con = new Connection();
		$query = "SELECT id, isbn, descripcao, paginas, editora, link, imgprev,  datapublica, titulo FROM livro
		 where titulo like '%" . $titulo . "%';";
		$db_con -> executeQuery($query);
		$livros=$this->getBooksFromDbQuery($db_con);

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
		$db_con = new Connection();
		$query = "SELECT id, isbn, descripcao, paginas, editora, link, imgprev,  datapublica, titulo FROM livro
		 where id = '" . $id . "';";
		$db_con -> executeQuery($query);
		$livros=$this->getBooksFromDbQuery($db_con);
        if(count($livros)>0){
            return $livros[0];
        }else{

			$extrabooks = $this -> searchGBBooksById($id);
			foreach ($extrabooks as $livro) {
				return $livro;
			}
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
		//echo "o criterio é".$isbn;
		$db_con = new Connection();
		$query = "SELECT id, isbn, descripcao, paginas, editora, link, imgprev,  datapublica, titulo FROM livro
		 where descripcao like '%" . $subject . "%';";
		$db_con -> executeQuery($query);
		$livros=$this->getBooksFromDbQuery($db_con);

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
		$db_con = new Connection();
		$query = "SELECT id, isbn, descripcao, paginas, editora, link, imgprev,  datapublica, titulo FROM livro
		 where descripcao like '%" . $all . "%' or isbn like '%" . $all . "%' or id like '%" . $all . "%' or
		 paginas like '%" . $all . "%' or editora like '%" . $all . "%' or link like '%" . $all . "%' or
		 imgprev like '%" . $all . "%' or datapublica like '%" . $all . "%' or  titulo like '%" . $all . "%'  ;";
		$db_con -> executeQuery($query);
		$livros=$this->getBooksFromDbQuery($db_con);

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
			$book -> setTitulo($value['volumeInfo']['title']);

			$authors = $value['volumeInfo']['authors'];
			echo var_dump($value);
            if(count($authors)>0){
			foreach ($authors as $author) {
				$book -> addAutor($author);
			}
			}
			$book -> setId($value['id']);
			$book -> setPaginas($value['volumeInfo']['pageCount']);
			$book -> setEditora($value['volumeInfo']['publisher']);
			$book -> setLinkPrevio($value['volumeInfo']['previewLink']);
			$book -> setDatapublica($value['volumeInfo']['publishedDate']);
			$book -> setDescripcion($value['volumeInfo']['description']);
			if(isset($value['volumeInfo']['industryIdentifiers'])){
			$book -> setIsbn($value['volumeInfo']['industryIdentifiers'][0]['identifier']);
			}
			$book -> setImageLink($value['volumeInfo']['imageLinks']['thumbnail']);
			array_push($books, $book);
		}

		return $books;
	}

	/**
	 * Transforma uma cadena com espaços a uma cadena com os %20% correspondentes, para evitar erros  na solicitude Ex: olá mundo => olá%20%mundo
	 */
	function getCleanedCriteria($criteria) {
		$criteria = str_replace(" ", "%20", $criteria);
		return $criteria;
	}

	function cadastrarLivro($livro) {
		$results_final = array();
		$db_con = new Connection();
		$db_con -> initTransaction();
		//$db_con->executeQuery();
		$query = "SELECT * FROM livro where id='" . $livro -> getId() . "' or isbn='" . $livro -> getIsbn() . "'";
		$db_con -> executeQuery($query);
		//$row = $db_con -> getResultsAssoc();
		//var_dump($row);
		if (!$row = $db_con -> getResultsAssoc()) {//livro náo existe

			//perform the insert using pg_query
			$query = "INSERT INTO livro(id, isbn,titulo, descripcao, datapublica, paginas, editora, link, imgprev,       estado)
    VALUES ('" . $livro -> getId() . "','" . $livro -> getIsbn() . "','" . $livro -> getTitulo() . "','" . $livro -> getDescripcion() . "','" . $livro -> getDatapublica() . "','" . $livro -> getPaginas() . "','" . $livro -> getEditora() . "','" . $livro -> getLinkPrevio() . "','" . $livro -> getImageLink() . "','" . $livro -> getEstado() . "')";

			array_push($results_final, $db_con -> executeQuery($query));
			//cadastrar authores
			//	echo $livro->getAutores().var_dump($expression);

			if($livro&&$livro->getAutores()){
			foreach ($livro->getAutores() as $autor) {
				$query = "SELECT * FROM autor where name='" . $autor -> getNome() . "'";

				$db_con -> executeQuery($query);
				if (!$row = $db_con -> getResultsAssoc()) {//autor náo existe
					$query = "insert into autor(name) values('" . $autor -> getNome() . "')";
					array_push($results_final, $db_con -> executeQuery($query));
					$query = "SELECT LASTVAL() as id;";
					$db_con -> executeQuery($query);
					if ($row = $db_con -> getResultsAssoc()) {//autor náo existe
						$idautor = $row["id"];
						$query = "INSERT INTO livroautor(idautor, idlivro) VALUES ('" . $idautor . "','" . $livro -> getId() . "');";
						array_push($results_final, $db_con -> executeQuery($query));
						//echo "entreee";
					}
				} else {
					$query = "select id from autor where id = (select id from autor,livroautor where autor.id=livroautor.idautor and idlivro='" . $livro -> getId() . "' limit 1)  limit 1";
					$db_con -> executeQuery($query);
					if (!$row = $db_con -> getResultsAssoc()) {//autor náo tem livro
						$query = "select id from autor where name= '" . $autor -> getNome() . "'";
						$db_con -> executeQuery($query);
						if ($row = $db_con -> getResultsAssoc()) {//autor existe
							$idautor = $row["id"];
							$query = "INSERT INTO livroautor(idautor, idlivro) VALUES ('" . $idautor . "','" . $livro -> getId() . "');";
							array_push($results_final, $db_con -> executeQuery($query));
							//echo "entre dos ";

						}

					}
				}

			}
			}//fin if existe autor
		}

		//adicionar livro do usuario,
		//if user has registered the book
		$query = "SELECT estadolivro FROM livrousuario where idlivro='" . $livro -> getId() . "' and idusuario='" . $livro -> getDono() -> getIdusuario() . "'";
		$db_con -> executeQuery($query);
		//$row = $db_con -> getResultsAssoc();
		//var_dump($row);
		if (!$row = $db_con -> getResultsAssoc()) {//livro ainda náo cadastrado com o usuario
			$query = "INSERT INTO livrousuario(idlivro, idusuario, estadolivro)
		    VALUES ('" . $livro -> getId() . "', '" . $livro -> getDono() -> getIdusuario() . "',  '" . $livro -> getEstado() . "');";
			array_push($results_final, $db_con -> executeQuery($query));
		}
		$commit = true;
		foreach ($results_final as $result) {
			if (!$result) {
				$commit = false;
			}
		}

		if ($commit == true) {
			$db_con -> commitTransaction();

		} else {
			$db_con -> rollbackTransaction();
		}
		return $commit;
	}

	function cadastrarLivroUsuario($livro){
        $results_final = array();
		$db_con = new Connection();
		$db_con -> initTransaction();
		//adicionar livro do usuario,
		//if user has registered the book
		$query = "SELECT estadolivro FROM livrousuario where idlivro='" . $livro -> getId() . "' and idusuario='" . $livro -> getDono() -> getIdusuario() . "'";
		$db_con -> executeQuery($query);
		//$row = $db_con -> getResultsAssoc();
		//var_dump($row);
		if (!$row = $db_con -> getResultsAssoc()) {//livro ainda náo cadastrado com o usuario
			$query = "INSERT INTO livrousuario(idlivro, idusuario, estadolivro)
		    VALUES ('" . $livro -> getId() . "', '" . $livro -> getDono() -> getIdusuario() . "',  '" . $livro -> getEstado() . "');";
			array_push($results_final, $db_con -> executeQuery($query));
		}
		$commit = true;
		foreach ($results_final as $result) {
			if (!$result) {
				$commit = false;
			}
		}

		if ($commit == true) {
			$db_con -> commitTransaction();

		} else {
			$db_con -> rollbackTransaction();
		}
		return $commit;

	}

function getBooksToFeed($user,$ini=0,$quan=10){
			$db_con = new Connection();
			$this->maxResults=$quan;
			$this->startIndex=$ini;
            $this->updateFilters();
		$query = "select * from sp_getbookstofeed('" . $user->getIdusuario() . "','" . $ini . "','" . $quan . "');";
		$db_con -> executeQuery($query);
		$livros=$this->getBooksFromDbQuery($db_con);
		if(count($livros)>0){
		//	echo "entreeeeeeeeeeeeeee".count($livros);
			$thisautor=$livros[0]->getAutores()[0];
		//	echo " this autor ".$thisautor;
		}

		////echo count($livros);
		//echo " this max results ".$this->maxResults;
		if ($this -> maxResults > 0) {
			if(!isset($thisautor)){
				$thisautor="Jhon";//obter el autor com mais livros
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

}

/*
 $client = new Google_Client();
 $service = new Google_Service_Books($client);

 $gestor = new GestorLibros($service);
 //$libros = $gestor -> searchBooksByMultipleCriteria(11,'bruce eckel');
 $libros = $gestor -> searchBooksByTitle('java');
 foreach ($libros as $libro) {
 echo "el libro <br><br>" . $libro -> toString();
 }
 //echo var_dump($resp);*/
?>
