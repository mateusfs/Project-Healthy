<?php

class BaseCarrinho extends Base {

	const CODIGO = 'CODIGO';
	const IDESTADO = 'IDESTADO';
	const NOME = 'NOME';


	protected $codigo;
	protected $idestado;
	protected $nome;

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public function getIdestado()
	{
		return $this->idestado;
	}

	public function setIdestado($idestado)
	{
		$this->idestado = $idestado;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;

		$db = Database::getInstance();
		$sql = "SELECT * FROM CIDADE WHERE CODIGO = :CODIGO" ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Cidade();
				$obj->hydrate($result);

				return $obj;
			}

		} catch (PDOException $e) {
			throw new PDOException($e->getMessage());
		}
	}


	public function save() {

		$db = Database::getInstance();

		if ($this->codigo) {

			$sql = "
				UPDATE
					CIDADE
				SET
					IDESTADO = :IDESTADO
					, NOME = :NOME
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					CIDADE
				(
					CODIGO
					, IDESTADO
					, NOME
				) VALUES (
					:CODIGO
					, :IDESTADO
					, :NOME
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;
		$sqlParam[':IDESTADO'] = $this->idestado;
		$sqlParam[':NOME'] = $this->nome;


		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo) {
				$lastId = $db->query('SELECT SEQ_'.CIDADE.'.CURRVAL FROM DUAL');
				$lastId = $lastId[0]['currval'];
			}
			$db->commit();
			return $lastId;
		} catch (PDOException $e) {
			$db->rollBack();
			throw new PDOException($e->getMessage());
		}
	}

	public function delete() {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;

		$db = Database::getInstance();

		$sql = "
			DELETE FROM
				CIDADE
			WHERE
				CODIGO = :CODIGO
		";
		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			$db->commit();
		} catch (PDOException $e) {
			$db->rollBack();
			throw new PDOException($e->getMessage());
		}
	}



}