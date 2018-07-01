<?php

class BasePessoa extends Base {

	const CODIGO = 'CODIGO';
	const NOME = 'NOME';
	const SOBRENOME = 'SOBRENOME';
	const EMAIL = 'EMAIL';
	const SENHA = 'SENHA';
	const DATANASCIMENTO = 'DATANASCIMENTO';
	const CPF = 'CPF';
	const RG = 'RG';
	const IDENDERECO = 'IDENDERECO';
	const IDCARRINNO = 'IDCARRINHO';
	const EXCLUIDO = 'EXCLUIDO';
	const ADINISTRADOR = 'ADMINISTRADOR';

	protected $codigo;
	protected $nome;
	protected $sobrenome;
	protected $email;
	protected $senha;
	protected $dataNascimento;
	protected $cpf;
	protected $rg;
	protected $idEndereco;
	protected $idCarrinho;
	protected $excluido;
	protected $administrador;


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

	public function getSobrenome()
	{
		return $this->sobrenome;
	}

	public function setSobrenome($sobrenome)
	{
		$this->sobrenome = $sobrenome;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getSenha()
	{
		return $this->senha;
	}

	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

	public function getDataNascimento()
	{
		return $this->dataNascimento;
	}

	public function setDataNascimento($dataNascimento)
	{
		$this->dataNascimento = $dataNascimento;
	}

	public function getCpf()
	{
		return $this->cpf;
	}

	public function setCpf($cpf)
	{
		$this->cpf = $cpf;
	}

	public function getRg()
	{
		return $this->rg;
	}

	public function setRg($rg)
	{
		$this->rg = $rg;
	}

	public function getIdEndereco()
	{
		return $this->idEndereco;
	}

	public function setIdEndereco($idEndereco)
	{
		$this->idEndereco = $idEndereco;
	}

	public function getIdCarrinho()
	{
		return $this->idCarrinho;
	}

	public function setIdCarrinho($idCarrinho)
	{
		$this->idCarrinho = $idCarrinho;
	}

	public function getExcluido()
	{
		return $this->excluido;
	}

	public function setExcluido($excluido)
	{
		$this->excluido = $excluido;
	}

	public function getAdministrador()
	{
		return $this->administrador;
	}

	public function setAdministrador($administrador)
	{
		$this->administrador = $administrador;
	}

	public static function retrieveByPk($codigo) {

		$sqlParam = array();
		$sqlParam[':CODIGO'] = $codigo;


		$db = Database::getInstance();
		$sql = "SELECT * FROM PESSOA WHERE CODIGO = :CODIGO " ;
		try{
			$result = $db->queryOne($sql, $sqlParam);

			if (is_null($result)) {
				return null;
			} else {
				$obj = new Pessoa();
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
					PESSOA
				SET
					NOME = :NOME
					, SOBRENOME = :SOBRENOME
					, SENHA = :SENHA
					, DATANASCIMENTO = :DATANASCIMENTO
					, CPF = :CPF
					, RG = :RG
					, EMAIL = :EMAIL
					, IDENDERECO = :IDENDERECO
					, IDCARRINHO = :IDCARRINHO
					, ADMINISTRADOR = :ADMINISTRADOR
					, EXCLUIDO = :EXCLUIDO
				WHERE
					CODIGO = :CODIGO
			";

		} else {

			$sql = "
				INSERT INTO
					PESSOA
				(
					CODIGO
					, NOME
					, SOBRENOME
					, SENHA
					, DATANASCIMENTO
					, CPF
					, RG
					, EMAIL
					, IDENDERECO
					, IDCARRINHO
					, ADMINISTRADOR
					, EXCLUIDO
				) VALUES (
					CODIGO
					, :NOME
					, :SOBRENOME
					, :SENHA
					, :DATANASCIMENTO
					, :CPF
					, :RG
					, :EMAIL
					, :IDENDERECO
					, :IDCARRINHO
					, :ADMINISTRADOR
					, :EXCLUIDO
				)
			";

		}

		$sqlParam = array();
		$sqlParam[':NOME'] = $this->nome;
		$sqlParam[':SOBRENOME'] = $this->sobrenome;
		$sqlParam[':SENHA'] = $this->senha;
		$sqlParam[':DATANASCIMENTO'] = $this->dataNascimento;
		$sqlParam[':CPF'] = $this->cpf;
		$sqlParam[':RG'] = $this->rg;
		$sqlParam[':EMAIL'] = $this->email;
		$sqlParam[':IDENDERECO'] = $this->idEndereco;
		$sqlParam[':IDCARRINHO'] = $this->idCarrinho;
		$sqlParam[':ADMINISTRADOR'] = $this->administrador;
		$sqlParam[':EXCLUIDO'] = $this->excluido;


				try{
			$db->beginTransaction();
			$db->execute($sql, $sqlParam);
			if (!$this->codigo ) {
				$lastId = $db->query('SELECT SEQ_'.PESSOA.'.CURRVAL FROM DUAL');
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
				PESSOA
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