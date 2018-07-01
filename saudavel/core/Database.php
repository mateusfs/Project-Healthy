<?php
class Database{

	private static $database;
	private $pdo;

	private function __construct(){

		$db_user = 'root';
		$db_pass = "";
		$db_name = 'mysql:host=localhost;dbname=bancosaudavel';

		try {

			$this->pdo = new PDO($db_name, $db_user, $db_pass);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_PERSISTENT, TRUE);
			$this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
		} catch (Exception $e) {
			throw new PDOException($e->getMessage(), $e->getCode());
		}


	}

	public static function getInstance(){

		if(Database::$database == null){
			Database::$database = new Database();
		}

		return Database::$database;
	}

	public function setSearchPathTo( $schema, $public = true ) {

		$pathsTo = '';
		$sep = '';

		if ($public) {
			$pathsTo = 'public';
			$sep = ', ';
		}

		if (count($schema)) {
			$pathsTo.= $sep.implode(', ', $schema);
		}

		self::exec('SET search_path TO '.$pathsTo.';');
	}


	public function query( $sql, $sqlParam = array()) {

		$statement = $this->execute($sql, $sqlParam);


		return $statement->fetchAll(PDO::FETCH_ASSOC);

	}

	public static function executeOci($sql, $sqlParam){
		try{

			$conexao =  oci_connect('banco_saudavel', 'senha', 'BancoSaudavel');
			$stmt = oci_parse($conexao, $sql);

			$values = array_values($sqlParam);
			$i = 0;
			foreach($sqlParam as $key => $value){
				oci_bind_by_name($stmt, $key, $values[$i]);
				$i++;
			}


			oci_execute($stmt);

			oci_free_statement($stmt);
			oci_close($conexao);

		}catch(Exception $exception){
			throw $exception;
		}
	}

	public function execute( $sql, $sqlParam = array()) {

		$parameters = array();
		$executarOci = false;

		$sqlParamExecute = array();
		foreach($sqlParam as $index => $value){
			$sqlParamExecute[$index] = urldecode($value);
		}

		$statement = $this->pdo->prepare($sql);

		try{
			$statement->execute($sqlParamExecute);
		}catch(PDOException $e){
			if($e->errorInfo[1] == '12899'){
				$column = $e->errorInfo[2];
				$columnError = explode("\"", $column);
				$coluna = $columnError[sizeof($columnError)-2];
				$parameters[":".$coluna] = substr($parameters[":".$coluna],0,250);

				$statement = $this->pdo->prepare($sql);
				$statement->execute($parameters);
			}else{
				throw $e;
			}
		}
		return $statement;
	}

	public function prepare($sql){
		$statement = $this->pdo->prepare($sql);
		return $statement;
	}


	public function queryOne( $sql, $sqlParam = array()) {

		$exec = $this->query($sql, $sqlParam);

		if ($exec) {
			return current($exec);
		} else {
			return null;
		}

	}

	public function countRolls( $sql, $sqlParam = array() ) {

		$tmplinha = uniqid();


		$pattern = '/[\n]/';
		$sql = preg_replace($pattern, $tmplinha, $sql);


		$pattern = '/(\/\*(.*)\/)/';
		$sql = preg_replace($pattern, '', $sql);


		$pattern = '/'.$tmplinha.'/';
		$sql = preg_replace($pattern, "\n", $sql);


		$pattern = '/(\--.*)/';
		$sql = preg_replace($pattern, '', $sql);


		$pattern = '/[\t\n]/';
		$sql = preg_replace($pattern, ' ', $sql);


		$pattern = '/((LIMIT|OFFSET)[\w\s]+\d+)$/i';
		$sql = preg_replace($pattern, '', trim($sql));


		$statement = $this->pdo->prepare($sql);
		$statement->execute($sqlParam);

		return $statement->rowCount();

	}

	public function beginTransaction(){
		$this->pdo->beginTransaction();
	}

	public function commit(){
		$this->pdo->commit();
	}

	public function rollBack(){
		$this->pdo->rollBack();
	}

	public static function retrieveClob($clob){
		return stream_get_contents($clob);
	}
}
