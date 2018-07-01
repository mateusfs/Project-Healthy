<?php

class BaseProduto extends Base {

	const CODIGO = 'CODIGO';
	const NOME = 'NOME';
	const DESCRICAO = 'DESCRICAO';
	const ESTOQUE = 'ESTOQUE';
	const VALOR = 'VALOR';
	const TAMANHO = 'TAMANHO';

	protected $codigo;
	protected $nome;
	protected $descricao;
	protected $estoque;
	protected $valor;
	protected $tamanho;

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	public function getEstoque()
	{
		return $this->estoque;
	}

	public function setEstoque($estoque)
	{
		$this->estoque = $estoque;
	}

	public function getValor()
	{
		return $this->valor;
	}

	public function setValor($valor)
	{
		$this->valor = $valor;
	}

	public function getTamanho()
	{
		return $this->tamanho;
	}

	public function setTamanho($tamanho)
	{
		$this->tamanho = $tamanho;
	}

	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;


		$db = Database::getInstance();
		$sql = "SELECT * FROM PRODUTO WHERE CODIGO = :CODIGO " ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Produto();
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
					PRODUDO
				SET
					NOME = :NOME
					, DESCRICAO = :DESCRICAO
					, ESTOQUE = :ESTOQUE
					, VALOR = :VALOR
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					PRODUTO
				(
					CODIGO
					, NOME
					, DESCRICAO
					, ESTOQUE
					, VALOR
				) VALUES (
					:CODIGO
					, :NOME
					, :DESCRICAO
					, :ESTOQUE
					, :VALOR
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;

		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo ) {
				$lastId = $db->query('SELECT SEQ_'.PRODUTO.'.CURRVAL FROM DUAL');
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
				PRODUTO
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