<?php
class SaudRoute {

	protected $saud;

	protected $root;

	protected $app;

	protected $controller;

	protected $action;

	protected $parameters;


	public function __construct( saud $saud ) {
		$this->saud = $saud;
		$this->root = dirname(dirname(__FILE__));
		$this->parameters = array();

		try {
			$this->map();
		} catch (Exception $e) {
			$this->saud->setException($e);
		}

	}

	public function getRoot() {
		return $this->root;
	}

	public function getApp() {
		return $this->app;
	}

	public function getController() {
		return $this->controller;
	}

	public function getAction() {
		return $this->action;
	}

	public function setNewRoute($controller, $action) {

		$this->controller = $controller;

		$this->action = $action;

	}

	private function map() {

		$app_default = $this->saud->getConfig(saud::KEY_APP_DEFAULT);

		$app = $app_default;
		$this->app = $app;


		$path = trim($this->saud->getEnv('PATH_INFO'), '/');

		if (!$path) {
			$modulo = 'index';
			$acao = 'index';
		} else {

			$requestURI = explode('/', $path);

			$app = current($requestURI);
			$dirname = $this->root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $app;

			if (!is_dir($dirname)) {
				$app = $app_default;
				$dirname = $this->root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $app;

				if (!is_dir($dirname)) {
					throw new ErrorException('App nao encontrada - '.current($requestURI));
				}
			} else {
				array_shift($requestURI);
			}

			$this->app = $app;



			if (!count($requestURI)) {
				$modulo = 'index';
			} else {

				$modulo = current($requestURI);
				$dirname = $this->root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $modulo;
				if (!is_dir($dirname)) {
					throw new Exception('Modulo não encontrado - '.$modulo);
				}
				array_shift($requestURI);
			}



			if (!count($requestURI)) {
				$acao = 'index';
			} else {

				$acao = current($requestURI);
				$class = $modulo . 'Controller';

				$filename = $this->root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $modulo . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $class . '.php';
				if (!file_exists($filename)) {
					throw new ErrorException('Controller nao encontrado - '.$class.'.php');
				}
				include_once $filename;

				$controller = new $class($this->saud);

				if (!is_callable(array($controller, $acao))) {
					throw new Exception ('Action nao encontrada - '.$acao);
				}

				array_shift($requestURI);
			}

			$this->action = $acao;



			if (count($requestURI)) {

				while (count($requestURI)) {

					$key = current($requestURI);

					array_shift($requestURI);

					$value = current($requestURI);

					$parameters[$key] = $value;

					array_shift($requestURI);
				}


				$_GET = array_merge($_GET, $parameters);
			}

			$this->parameters = $_GET;
		}


		$this->controller = $modulo;


		$this->action = $acao;

	}

	public function getPathController( $class ) {

		$filename = $this->root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $this->app . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $this->controller . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $class . '.php';

		if (!file_exists($filename)) {
			throw new ErrorException('Controller não existe');
		}

		return $filename;
	}

	public function getPathView( $view ) {

		$filename = $this->root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $this->app . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $this->controller . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $view . '.php';

		if (!file_exists($filename)) {
			throw new ErrorException('View nao existe');
		}

		return $filename;
	}

	public function getPathLayout( $layout ) {

		$filename = $this->root . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . $layout . '.php';

		if (!file_exists($filename)) {
			throw new ErrorException('Layout nao existe');
		}

		return $filename;
	}

	public function getParameters( $indice = null ){
		if (!is_null($indice)){
			if (isset($this->parameters[$indice])) {
				return trim($this->parameters[$indice]);
			} else {
				return null;
			}
		}
		return $this->parameters;
	}
}