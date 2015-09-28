<?php
namespace App\Models;
class User {
	private $idusuario;
	private $nomeusuario;

	function setIdusuario($idusuario) { $this -> idusuario = $idusuario;
	}

	function getIdusuario() {
		return $this -> idusuario;
	}

	function setNomeusuario($nomeusuario) { $this -> nomeusuario = $nomeusuario;
	}

	function getNomeusuario() {
		return $this -> nomeusuario;
	}

}
?>
