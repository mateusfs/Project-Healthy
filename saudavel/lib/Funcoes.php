<?php
class Funcoes {
	
	public function __construct() {
	}

	public static function pegaHoraMinutos($val){
		$result = explode(":", $val);

		return $result[0].':'.$result[1];
	}

	public static function validaData($data){
		$d = explode("/", $data);
		if(count($d) == 3 && is_numeric($d[0]) && is_numeric($d[1]) && is_numeric($d[2]) && checkdate($d[1], $d[0], $d[2])) {
			if($d[2] < 1902){
				return false;
			}else if($d[2] > 2050){
				return false;
			}
		 	return true;
		}
		return false;
	}

    public static function dataFromDb($data)
    {
    	$arrTemp = explode(" ", $data);
    	
        return(implode("/", array_reverse(explode("-", $arrTemp[0]))));
    }

  
    public static function dataToDb($data)
    {
        return(implode("-", array_reverse(explode("/", $data))));
    }
	
	
	public static function antiInjection($string){
		$string = preg_replace(sql_regcase('/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/'),"",$string);
		$string = trim($string);
		$string = strip_tags($string);
		$string = addslashes($string);
		return $string;
	}

	public static function validaImagem ($file, $extensoes = array('jpg', 'jpeg', 'gif', 'png')) {
		$erro = null;
		if ($file['error'] == UPLOAD_ERR_NO_FILE) {
			$erro = 'Por favor informe o arquivo';
		} else {
			$ext = array_reverse(explode('.', $file['name']));
			if (!in_array(strtolower($ext[0]), $extensoes)) {
				$erro = 'Arquivo com extensão diferente das permitidas ( '.implode(', ', $extensoes).' )';
			}
		}
		
		return $erro;
	}
	
	
	public static function validaEmail($mail){
		if(preg_match('/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/', $mail)) {
			return true;
		}else{
			return false;
		}
	}
	
	
	public static function javascript($conteudo) {
		
		$javascript = "<script type='text/javascript'>".$conteudo."</script>";
		
		return $javascript;
	}
	
	public static function mes($mes) {
		$arr = array(
			"01" => "jan"
			, "02" => "fev"
			, "03" => "mar"
			, "04" => "abr"
			, "05" => "mai"
			, "06" => "jun"
			, "07" => "jul"
			, "08" => "ago"
			, "09" => "set"
			, "10" => "out"
			, "11" => "nov"
			, "12" => "dez"
		);
		
		return $arr[$mes];
	}
	
	public static function tresPontinhos($string, $length = 30) {
		$result = substr($string, 0, $length);
		if(strlen($string) >= $length){
			return $result."...";
		}else{
			return $result;
		}
	}

}

?>
