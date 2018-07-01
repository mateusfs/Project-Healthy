<?php


class BaseEstado extends Base {

	const CODIGO = 'CODIGO';
	const SIGLA = 'SIGLA';
	const NOME = 'NOME';

	protected $codigo;
	protected $sigla;
	protected $nome;

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public function getSigla()
	{
		return $this->sigla;
	}

	public function setSigla($sigla)
	{
		$this->sigla = $sigla;
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
		$sql = "SELECT * FROM ESTADO WHERE CODIGO = :CODIGO" ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Estado();
				$obj->hydrate($result);

				return $obj;
			}

		} catch (PDOException $e) {
			throw new PDOException($e->getMessage());
		}
	}


	public function save() {

		$db = Database::getInstance();

		if ($this->idpedido   && $this->idproduto  ) {

			$sql = "
				UPDATE
					ESTADO
				SET
					SIGLA = :SIGLA
					, NOME = :NOME
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					ESTADO
				(
					CODIGO
					, SIGLA
					, NOME
				) VALUES (
					:CODIGO
					, :SIGLA
					, :NOME
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;
		$sqlParam[':SIGLA'] = $this->sigla;
		$sqlParam[':NOME'] = $this->nome;

		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo) {
				$lastId = $db->query('SELECT SEQ_'.ESTADO.'.CURRVAL FROM DUAL');
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
		$sqlParam[':CODIGO'] = $codigo;


		$db = Database::getInstance();

		$sql = "
			DELETE FROM
				ESTADO
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