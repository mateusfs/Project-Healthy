<?php

class BasePedido extends Base {

	const CODIGO = 'CODIGO';
	const IDCIDADE = 'IDCIDADE';
	const IDSTATUS = 'IDSTATUS';
	const IDCARRINHO = 'IDCARRINHO';
	const CEP = 'CEP';
	const DATA = 'DATA';
	const BAIRRO = 'BAIRRO';
	const NUMERO = 'NUMERO';
	const RUA = 'RUA';
	const VALOR = 'VALOR';



	protected $codigo;
	protected $idCidade;
	protected $idStatus;
	protected $idCarrinho;
	protected $cep;
	protected $data;
	protected $bairro;
	protected $numero;
	protected $rua;
	protected $valor;

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public function getIdCidade()
	{
		return $this->idCidade;
	}

	public function setIdCidade($idCidade)
	{
		$this->idCidade = $idCidade;
	}

	public function getIdStatus()
	{
		return $this->idStatus;
	}

	public function setIdStatus($idStatus)
	{
		$this->idStatus = $idStatus;
	}

	public function getIdCarrinho()
	{
		return $this->idCarrinho;
	}

	public function setIdCarrinho($idCarrinho)
	{
		$this->idCarrinho = $idCarrinho;
	}

	public function getCep()
	{
		return $this->cep;
	}

	public function setCep($cep)
	{
		$this->cep = $cep;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getBairro()
	{
		return $this->bairro;
	}

	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}

	public function getNumero()
	{
		return $this->numero;
	}

	public function setNumero($numero)
	{
		$this->numero = $numero;
	}

	public function getRua()
	{
		return $this->rua;
	}

	public function setRua($rua)
	{
		$this->rua = $rua;
	}

	public function getValor()
	{
		return $this->valor;
	}

	public function setValor($valor)
	{
		$this->valor = $valor;
	}


	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;


		$db = Database::getInstance();
		$sql = "SELECT * FROM PEDIDO WHERE CODIGO = :CODIGO " ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Pedido();
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
					PEDIDO
				SET
					IDCIDADE = :IDCIDADE
					, IDSTATUS = :IDSTATUS
					, IDCARRINHO = :IDCARRINNHO
					, CEP = :CEP
					, BAIRRO = :BAIRRO
					, RUA = :RUA
					, NUMERO = :NUMERO
					, DATA = :DATA
					, VALOR = :VALOR
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					PEDIDO
				(
					CODIGO
					, IDCIDADE
					, IDSTATUS
					, IDCARRINHO
					, CEP
					, BAIRRO
					, RUA
					, NUMERO
					, DATA
					, VALOR
				) VALUES (
					:CODIGO
					, :IDCIDADE
					, :IDSTATUS
					, :IDCARRINHO
					, :CEP
					, :BAIRRO
					, :RUA
					, :NUMERO
					, :DATA
					, :VALOR
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $this->codigo;
		$sqlParam[':IDCIDADE'] = $this->idCidade;
		$sqlParam[':IDSTATUS'] = $this->idStatus;
		$sqlParam[':IDCARRINHO'] = $this->idCarrinho;
		$sqlParam[':CEP'] = $this->cep;
		$sqlParam[':BAIRRO'] = $this->bairro;
		$sqlParam[':NUMERO'] = $this->numero;
		$sqlParam[':RUA'] = $this->rua;
		$sqlParam[':DATA'] = $this->data;
		$sqlParam[':VALOR'] = $this->valor;

		try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo ) {
				$lastId = $db->query('SELECT SEQ_'.PEDIDO.'.CURRVAL FROM DUAL');
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
				PEDIDO
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