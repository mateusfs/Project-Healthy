<?php
class CampoButton
{
	private $conteudo;

	function __construct($label, $name, $param = array(), $type = 'button') {

		$div = '';
		$input = "class='botao'";

		if(count($param) > 0){
			foreach($param as $tipo => $valores){
				$conteudo = '';
				$flag = false;
				foreach($valores as $atributo => $valor){

					if($atributo == 'class' && $tipo == 'input'){
						$conteudo.= $atributo."='botao {$valor}'";
						$flag = true;
					}else{
						$conteudo.= $atributo."=\"{$valor}\"";
					}
				}

				if(!$flag && $tipo == 'input'){
					$conteudo.= " class='botao' ";
				}

				switch($tipo){
					case 'div':
						$div = $conteudo;
						break;
					case 'input':
						$input = $conteudo;
						break;
				}
			}
		}

		$js = "";
		if($type == 'submit'){
			$js = "onclick=\"if(!checkSubmit()){ return false; }\"";
		}

		$this->conteudo = "
			<div {$div}>
				<input type='{$type}' value='".$label."' name='{$name}' id='{$name}' {$input} {$redirect} {$js} />
			</div>";
	}

	public function toHTML() {
		return "<div class='left button_space'>".$this->conteudo."</div>";
	}
}
?>
