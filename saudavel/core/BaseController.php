<?php
Abstract Class BaseController {


	protected $saud;

	public function __construct(Saud $saud) {
		$this->saud = $saud;
	}

	public function getPost($indice = null) {
		if (!is_null($indice)){
			if (isset($_POST[$indice])) {
				return $_POST[$indice];
			} else {
				return null;
			}
		}
		return $_POST;
	}

	public function getFile($indice = null){
		if (!is_null($indice)){
			if (isset($_FILES[$indice])) {
				return $_FILES[$indice];
			} else {
				return null;
			}
		}
		return $_FILES;
	}

	public function getRequest($indice = null) {
		if (!is_null($indice)){
			if (isset($_GET[$indice])) {
				return trim($_GET[$indice]);
			} else {
				return null;
			}
		}
		return $_GET;
	}



	public function getUsuario($sessionName = Sessao::USUARIO) {
		return Sessao::sessionGet($sessionName);
	}


	public function setUsuario($obj, $sessionName = Sessao::USUARIO) {
		Sessao::sessaoSet($sessionName, $obj);
	}

	abstract function index();
}