<?php
class CampoLink
{
	private $conteudo;
	
    function __construct($label, $name,  $redirect, $param = array(), $type = 'button') {

		$div = '';
		$input = "class='botao_link'";
		
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
					$conteudo.= " class='botao_link' ";
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

		$this->conteudo = "
			<div {$div}>
				<a href='{$redirect}' id='{$name}' {$input}  >".$label."</a>
			</div>";
    }
    
    public function toHTML() {
    	return "<div class='left button_space'>".$this->conteudo."</div>";
    }
}
?>
