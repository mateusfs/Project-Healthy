<?php
class Base {

	private $new;
	protected $conexaoPersistente;
	
	public function __construct() {
		$this->conexaoPersistente = false;
	}
	
	private function arrToMethodName($arr) {
		$tmp = explode('_', $arr);

		$string = 'set';
		foreach($tmp as $valor) {
			$string.= ucfirst($valor);
		}

		return $string;
	}

	protected function timeToDate($v, $format = "Y-m-d H:i:s") {

		if ($v) {
			
			if (is_numeric($v)) {
				$v = date($format, $v);
			} else {
				$tmp = explode("/", $v);
				if (count($tmp) > 1) {
					$v = implode("-", array_reverse(explode("/", $v)));
				}
			}

			$v = "'".$v."'";
		} else {
			$v = "NULL";
		}

		return $v;
	}

	
	protected function numOrNull($v) {

		if (!is_numeric($v)) {
			$v = "NULL";
		}

		return $v;

	}
	
	protected function booleanStr($v) {

		if ($v !== null) {
			$v = ((boolean)$v ? 'TRUE' : 'FALSE');
		} else {
			$v = 'NULL';
		}
		
		return $v;
		
	}
	
	public function setConexaoPersistente($bool) {
		$this->conexaoPersistente = $bool;
	}
	
	public function setNew($bool = false) {
		$this->new = $bool;
	}
	
	public function getNew() {
		return $this->new;
	}
	
	public function hydrate($array) {
		if (is_array($array) && !empty($array)) {
			foreach ($array as $k=>$v) {
				$methodName = $this->arrToMethodName($k);
	
				if (method_exists($this, $methodName)) {
					$this->$methodName($v);
				}
			}
		}
	}

}