<?php
namespace App\Models;
class Autor {
	private $id;//identificaçao do autor
	private $nome;//nome completo do autor

	/**
	 * @param $id, asignar valor ao identificador do livro
	 */
	function setId($id) { $this -> id = $id;
	}

	/**
	 * obter valor do identificador do livro
	 */
	function getId() {
		return $this -> id;
	}
	/**
	 * @param $nome dotar dum nome ao author
	 *
	 */
	function setNome($nome) { $this -> nome = $nome;
	}
	/**
	 * obter nome do author
	 *
	 */
	function getNome() {
		return $this -> nome;
	}

}
?>
