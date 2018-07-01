<?php
class CampoTitulo extends Artefato
{
	
	
    function __construct($label, $classDiv) {

		$this->conteudo = "
			<div class='{$classDiv}' >".$label."</div>";
	}
    
}
?>