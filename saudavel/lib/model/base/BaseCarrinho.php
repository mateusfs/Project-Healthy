<?php

class BaseCarrinho extends Base {

	const CODIGO = 'CODIGO';
	const VALORTOTAL = 'VALORTOTAL';
	const IDPESSOA = 'IDPESSOA';

	protected $codigo;
	protected $valortotal;
	protected $idpessoa;


	public function getValortotal()
	{
		return $this->valortotal;
	}

	public function setValortotal($valortotal)
	{
		$this->valortotal = $valortotal;
	}

	public function getIdpessoa()
	{
		return $this->idpessoa;
	}

	public function setIdpessoa($idpessoa)
	{
		$this->idpessoa = $idpessoa;
	}

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;

		$db = Database::getInstance();
		$sql = "SELECT * FROM CARRINHO WHERE CODIGO = :CODIGO" ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Carrinho();
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
					CARRINHO
				SET
					IDPESSOA = :IDPESSOA
					, VALORTOAL = :VALORTOAL
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					CARRINHO
				(
					CODIGO
					, IDPESSOA
					, VALROTOTAL
				) VALUES (
					:CODIGO
					, :IDPESSOA
					, :VALORTOTAL
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;
		$sqlParam[':IDPESSOA'] = $this->idpessoa;
		$sqlParam[':VALORTOTAL'] = $this->valortotal;


		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo) {
				$lastId = $db->query('SELECT SEQ_'.CARRINHO.'.CURRVAL FROM DUAL');
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
				CARRINHO
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