<?php
class SaudEnviroment {
	
	protected $environment;
	
	
	public function __construct() {
		
		$env = array ();
		
		$env['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
		
		$env['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
		
		if (strpos ( $_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'] ) === 0) {
			$env['SCRIPT_NAME'] = $_SERVER['SCRIPT_NAME'];
		} else {
			$env['SCRIPT_NAME'] = str_replace ( '\\', '/', dirname ( $_SERVER['SCRIPT_NAME'] ) ); 
		}

		$env['PATH_INFO'] = substr_replace ( $_SERVER['REQUEST_URI'], '', 0, strlen ( $env['SCRIPT_NAME'] ) );
		
		if (strpos ( $env['PATH_INFO'], '?' ) !== false) {
			$env['PATH_INFO'] = substr_replace ( $env['PATH_INFO'], '', strpos ( $env['PATH_INFO'], '?' ) ); 
		}
		
		$env['SCRIPT_NAME'] = rtrim ( $env['SCRIPT_NAME'], '/' );
		
		$env['PATH_INFO'] = '/' . ltrim ( $env['PATH_INFO'], '/' );
		
		$env['QUERY_STRING'] = isset ( $_SERVER['QUERY_STRING'] ) ? $_SERVER['QUERY_STRING'] : '';
		
		$env['SERVER_NAME'] = $_SERVER['SERVER_NAME'];
		
		$env['SERVER_PORT'] = $_SERVER['SERVER_PORT'];
		
		$specialHeaders = array ('CONTENT_TYPE', 'CONTENT_LENGTH', 'PHP_AUTH_USER', 'PHP_AUTH_PW', 'PHP_AUTH_DIGEST', 'AUTH_TYPE' );
		foreach ( $_SERVER as $key => $value ) {
			$value = is_string ( $value ) ? trim ( $value ) : $value;
			if (strpos ( $key, 'HTTP_' ) === 0) {
				$env[substr ( $key, 5 )] = $value;
			} else if (strpos ( $key, 'X_' ) === 0 || in_array ( $key, $specialHeaders )) {
				$env[$key] = $value;
			}
		}
		
		$env['PROTOCOL'] = (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') ? 'http' : 'https';
		
		
		$this->environment = $env;
	}
	
	public function getEnv( $env ) {
		return (isset($this->environment[$env]) ? $this->environment[$env] : null);
	}
	
	public function setEnv( $key, $value ) {
		$this->environment[$key] = $value;
	}
}