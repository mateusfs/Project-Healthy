<?php
spl_autoload_register(array('Saud', 'saudAutoload'));

class Saud {

	const KEY_APP_DEFAULT 	= 'app_default';
	const DEBUG_TRUE		= TRUE;
	const DEBUG_FALSE		= FALSE;
	const WWW_BASE			= 'www_base';


	private $saud_layout;


	protected $saud_exception;


	protected $saud_cache_exception;


	private $saud_vars;


	protected $saud_environment;


	protected $saud_router;


	protected static $saud_autoload = array(
		'core'
		, 'lib'
	);


	protected $saud_settings = array(
		'app_default' 	=> 'default'
		, 'debug'		=> FALSE
		, 'www_base'	=> ''
		, 'domain'		=> ''
		, 'favicon'		=> 'web/img/favicon.ico'
		, 'default' 	=> array(
								'head' => array(
										'title' 		=> ''
										, 'description' => ''
										, 'keywords' 	=> ''
										, 'analytics' 	=> ''
								)
								, 'css' => array()
								, 'javascript' => array()

							)
	);




	private static function saudSanDir( $base = '', &$data = array() ) {

		$array = array_diff(scandir($base), array('.', '..'));

		foreach($array as $value) {

			if (is_dir($base.$value)) {
				$data[] = $base.$value.'/';
				$data = self::saudSanDir($base.$value.'/', $data);
			}

		}

		return $data;
	}

	public static function saudAutoload( $class ) {

		$arrOpcoes = array();
		foreach (self::$saud_autoload as $value) {

			$dir_path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $value . '/';

			$arrOpcoes[] = $dir_path;

			$arrOpcoes = array_merge($arrOpcoes, self::saudSanDir($dir_path));
		}

		$filename = $class . '.php';

		foreach ($arrOpcoes as $dir) {
			$file = $dir . $filename;

			if (file_exists ( $file )) {
				require_once ($file);
				return true;
			}
		}

	}

	public function __set($index, $value) {
		$this->saud_vars[$index] = $value;
	}

	public function __get($index) {
		return $this->saud_vars[$index];
	}

	public function setLayout($layout) {
		$this->saud_layout = $layout;
	}

	public function setException(Exception $e) {
		$this->saud_exception = $e;
	}

	public function setCacheException(Exception $e) {
		$this->saud_exception = null;
		$this->saud_cache_exception = $e;
	}

	public function setConfig( $key, $value ) {
		$this->saud_settings[$key] = $value;
	}

	public function getExceptionMessage() {
		return $this->saud_exception_message;
	}

	public function getApp() {
		if(!$this->saud_router){
			return ;
		}
		return $this->saud_router->getApp();
	}

	public function getController() {
		if(is_object($this->saud_router)){
			return $this->saud_router->getController();
		}
	}

	public function getAction() {
		if(is_object($this->saud_router)){
			return $this->saud_router->getAction();
		}
	}

	public function getConfig( $chave= '' ) {
		if ($chave) {
			return (isset($this->saud_settings[$chave]) ? $this->saud_settings[$chave] : null);
		}
		return $this->saud_settings;
	}

	public function getEnv( $env ) {
		return $this->saud_environment->getEnv($env);
	}


	public function getRoute() {
		return $this->saud_route;
	}


	private function array_merge_recursive_distinct () {
		$arrays = func_get_args();
		$base = array_shift($arrays);
		if(!is_array($base)) $base = empty($base) ? array() : array($base);
		foreach($arrays as $append) {
			if(!is_array($append)) $append = array($append);
			foreach($append as $key => $value) {
				if(!array_key_exists($key, $base) and !is_numeric($key)) {
					$base[$key] = $append[$key];
					continue;
				}
				if(is_array($value) || (isset($base[$key]) && is_array($base[$key]))) {
					$base[$key] = $this->array_merge_recursive_distinct($base[$key], $append[$key]);
				} else if(is_numeric($key)) {
					if(!in_array($value, $base)) $base[] = $value;
				} else {
					$base[$key] = $value;
				}
			}
		}
		return $base;
	}


	public function __construct( $settings = array() ) {

		$this->saud_environment = new SaudEnviroment();

		$this->setConfig(self::WWW_BASE, $this->getEnv('PROTOCOL').'://'.$this->getEnv('SERVER_NAME').(ltrim($this->getEnv('SCRIPT_NAME')) ? $this->saud_environment->getEnv('SCRIPT_NAME').'/': $this->getEnv('SCRIPT_NAME')));
		$this->saud_settings = $this->array_merge_recursive_distinct($this->saud_settings, $settings);

		$this->saud_router = new SaudRoute($this);


		$this->saud_layout = $this->getApp();
	}



	public function run() {
		
		$class = $this->getController() . 'Controller';
		
		if ($this->saud_exception) {
			throw $this->saud_exception;
		}
		
		include_once $this->saud_router->getPathController($class);
			
		$controller = new $class($this);
		$controller->{$this->getAction()}();
	}



	public function show($view, $useLayout = true) {

		try {
			$path = $this->saud_router->getPathView($view);

			if ($this->saud_vars) {
				foreach ($this->saud_vars as $key => $value) {
					$$key = $value;
				}
			}

			if ($useLayout) {
				require_once $this->saud_router->getPathLayout($this->saud_layout);
			} else {
				require_once ($path);
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}


	}


	public function redirect ($controller = '', $action = '', $app = ''){

		$protocol 	= $this->getEnv('PROTOCOL');
		$host  		= $this->getEnv('SERVER_NAME');
		$uri   		= $this->getEnv('SCRIPT_NAME');


		if ($app) {
			$uri.= '/'.$app;
		} else if ($this->getApp() != $this->getConfig(self::KEY_APP_DEFAULT)) {
			$uri.= '/'.$this->getApp();
		}


		$extra = "";
		if ($controller) {
			$extra.= '/' . $controller;
		}

		if ($controller && $action) {
			$extra.= '/' . $action;
		}

		header("Location: ".$protocol."://".$host . $uri . $extra);

	}


	public function forward ($controller, $action = 'index') {
		$this->saud_router->setNewRoute($controller, $action);
		$this->run();
	}


	public function setRequestParameter($chave, $valor) {
		$this->saud_parameters[$chave] = $valor;
	}


	public function getRequestParameter($chave = null) {

		if(!is_null($chave)) {
			if (isset($this->saud_parameters[$chave])) {
				return $this->saud_parameters[$chave];
			}
			return null;
		}else{
			return $this->saud_parameters;
		}
	}

}