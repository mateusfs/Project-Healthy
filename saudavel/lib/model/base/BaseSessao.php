<?php
class BaseSessao extends Base {

	const TABLE_NAME = 'SESSAO';
	const CODIGO = 'CODIGO';
	const TOKEN = 'TOKEN';

	protected $codigo;
	protected $token;



	public function setCodigo($codigo) {
		$this->codigo = $codigo;
	}


	public function getCodigo() {
		return $this->codigo;
	}


	public function setToken($token) {
		$this->token = $token;
	}


	public function getToken() {
		return $this->token;
	}

	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;


		$db = Database::getInstance();
		$sql = "SELECT * FROM SESSAO WHERE CODIGO = :CODIGO " ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Sessao();
				$obj->hydrate($result);

				return $obj;
			}

		} catch (PDOException $e) {
			throw new PDOException($e->getMessage());
		}
	}


	public function save() {

		$db = Database::getInstance();

		if ($this->codigo  ) {

			$sql = "
				UPDATE
					SESSAO
				SET
					CODIGO = :CODIGO
					, TOKEN = :TOKEN
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					SESSAO
				(
					CODIGO
					, TOKEN
				) VALUES (
					:CODIGO
					, :TOKEN
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;
		$sqlParam[':TOKEN'] = $this->token;

		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo ) {
				$lastId = $db->query('SELECT SEQ_'.SESSAO.'.CURRVAL FROM DUAL');
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
				SESSAO
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