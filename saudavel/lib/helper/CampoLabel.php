<?php
class CampoLabel extends Artefato
{
	
	
    function __construct($label, $value, $limit = true, $name = '') {

		$this->conteudo = "
			<div ";
		if($limit){
			$this->conteudo .= "class='div_linha'";
		}
		
		$this->conteudo .="  >
				<div class='linha_descricao'><label  for='{$name}'><span {$span}>".$label . $obrigatorio . $observacao." :</span></label></div>
				<div ";

		if($limit){
			$this->conteudo .= "class='linha_campo_input' id='linha_campo_input_".$name."'";	
		}else{
			$this->conteudo .= " style='margin-left: 170px;' ";
		}
		
		$this->conteudo .= ">";
		
		
		$this->conteudo .= "{$value}</div>
				<div class='clear'></div>
			</div>";
	}
    
}
?>