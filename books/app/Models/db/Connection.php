<?php

/**
 *
 */
 namespace App\Models\db;
class Connection {

	private $connectionStrings;
	private $connection;
	private $connectionIndex;
	private $results;
	private $lastrowresult;
	function __construct($connectionIndex = 0) {
		$this -> initConnectionStrings();
		$this -> initConnection($connectionIndex);
		$this -> connectionIndex = $connectionIndex;

	}

	function initConnectionStrings() {
		$this -> connectionStrings = array("host=localhost dbname=postgres user=postgres password=asenna");
	}

	function initConnection($connectionIndex) {
		$this -> connection = pg_connect($this -> connectionStrings[$connectionIndex]);
	}

	function executeQuery($query) {
		//echo $query;
		$this -> initConnection($this -> connectionIndex);
		$this -> results = pg_query($this -> connection, $query);
		return $this->results;
	}

	function getResultsAssoc() {
		$this->lastrowresult=pg_fetch_assoc($this -> results);
		return $this->lastrowresult;
	}

	function initTransaction(){
		$this->executeQuery("BEGIN");
	}

	function commitTransaction(){
		$this->executeQuery("COMMIT");
	}
	function rollbackTransaction(){
		$this->executeQuery("ROLLBACK");
	}
}
?>
