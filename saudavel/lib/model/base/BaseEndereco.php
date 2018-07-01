<?php

class BaseEndereco extends Base {

	const CODIGO = 'CODIGO';
	const CEP = 'CEP';
	const BAIRRO = 'BAIRRO';
	const RUA = 'RUA';
	const NUMERO = 'NUMERO';
	const DESCRICAO = 'DESCRICAO';
	const COMPLEMENTO = 'COPLEMENTO';
	const IDCIDADE = 'IDCIDADE';


	protected $codigo;
	protected $cep;
	protected $bairro;
	protected $rua;
	protected $numero;
	protected $descricao;
	protected $complemento;
	protected $idcidade;

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public function getCep()
	{
		return $this->cep;
	}

	public function setCep($cep)
	{
		$this->cep = $cep;
	}

	public function getBairro()
	{
		return $this->bairro;
	}

	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}

	public function getRua()
	{
		return $this->rua;
	}

	public function setRua($rua)
	{
		$this->rua = $rua;
	}

	public function getNumero()
	{
		return $this->numero;
	}

	public function setNumero($numero)
	{
		$this->numero = $numero;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	public function getComplemento()
	{
		return $this->complemento;
	}

	public function setComplemento($complemento)
	{
		$this->complemento = $complemento;
	}

	public function getIdcidade()
	{
		return $this->idcidade;
	}

	public function setIdcidade($idcidade)
	{
		$this->idcidade = $idcidade;
	}

	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;


		$db = Database::getInstance();
		$sql = "SELECT * FROM ENDERECO WHERE CODIGO = :CODIGO " ;

		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Endereco();
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
					ENDERECO
				SET
					BAIRRO = :BAIRRO
					, CEP = :CEP
					, NUMERO = :NUMERO
					, RUA = :RUA
					, DESCRICAO = :DESCRICAO
					, COMPLEMENTO = :COMPLEMENTO
					, IDCIDADE = :IDCIDADE
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					ENDERECO
				(
					CODIGO
					, BAIRRO
					, CEP
					, NUMERO
					, RUA
					, DESCRICAO
					, COMPLEMENTO
					, CIDADE
				) VALUES (
					:CODIGO
					, :BAIRRO
					, :CEP
					, :NUMERO
					, :RUA
					, :DESCRICAO
					, :COMPLEMENTO
					, :CIDADE
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;
		$sqlParam[':BAIRRO'] = $this->bairro;
		$sqlParam[':CEP'] = $this->cep;
		$sqlParam[':NUMERO'] = $this->numero;
		$sqlParam[':RUA'] = $this->rua;
		$sqlParam[':DESCRICAO'] = $this->estado;
		$sqlParam[':COMPLEMENTO'] = $this->estado;
		$sqlParam[':CIDADE'] = $this->cidade;


		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo ) {
				$lastId = $db->query('SELECT SEQ_'.ENDERECO.'.CURRVAL FROM DUAL');
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
				ENDERECO
			WHERE
				CODIGO = :CODIGO
		";
		if (!is_null($this->Codigo)) {
			$sql.= " AND CODIGO = :CODIGO";
			$sqlParam[':CODIGO'] = $this->codigo;
		}

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