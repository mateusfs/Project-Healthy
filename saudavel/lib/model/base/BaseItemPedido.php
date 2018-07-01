<?php

class BasePedido extends Base {

	const CODIGO = 'CODIGO';
	const IDPRODUTO = 'IDPRODUTO';
	const VALORUNITARIO = 'VALORUNITARIO';
	const QUANTIDADE = 'QUANTIDADE';



	protected $codigo;
	protected $idproduto;
	protected $valorUnitario;
	protected $quantidade;

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public function getIdproduto()
	{
		return $this->idproduto;
	}

	public function setIdproduto($idproduto)
	{
		$this->idproduto = $idproduto;
	}

	public function getValorUnitario()
	{
		return $this->valorUnitario;
	}

	public function setValorUnitario($valorUnitario)
	{
		$this->valorUnitario = $valorUnitario;
	}

	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade;
	}


	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $CODIGO;


		$db = Database::getInstance();
		$sql = "SELECT * FROM ITEMPEDIDO WHERE CODIGO = :CODIGO" ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new ItemPedido();
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
					ITEMPEDIDO
				SET
					IDPRODUTO = :IDPRODUTO
					, QUANTIDADE = :QUANTIDADE
					, VALOR_UNITARIO = :VALORUNITARIO
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					ITEMPEDIDO
				(
					CODIGO
					, IDPRODUTO
					, QUANTIDADE
					, VALOR_UNITARIO
				) VALUES (
					:CODIGO
					, :IDPRODUTO
					, :QUANTIDADE
					, :VALORUNITARIO
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;
		$sqlParam[':IDPRODUTO'] = $this->idproduto;
		$sqlParam[':QUANTIDADE'] = $this->quantidade;
		$sqlParam[':VALORUNITARIO'] = $this->valorUnitario;

		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->idpedido  && !$this->idproduto) {
				$lastId = $db->query('SELECT SEQ_'.ITEMPEDIDO.'.CURRVAL FROM DUAL');
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
				ITEMPEDIDO
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