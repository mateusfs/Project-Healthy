<?php
class CampoFieldset
{
	private $conteudo;
	private $id;
	private $param;
	private $legenda;

    function __construct($id, $legenda = '', $param = array()) {
    	$this->param = $param;
    	$this->id = $id;
    	$this->legenda = $legenda;
    }

    public function addConteudo($conteudo = null) {
    	if(!is_null($conteudo))
    		$this->conteudo[] = $conteudo;
    }
    
    public function toHTML() {
    	
    	$attr = '';
    	if(count($this->param) > 0){
    		foreach($this->param as $tipo => $valores){
    			foreach($valores as $atributo => $valor){
    				$attr.= $atributo."=\"{$valor}\"";
    			}
    		}
    	}
    	
    	$div = "<div id='{$this->id}' {$attr}>
    	<fieldset class='fieldset_traducao'>
    		<legend>".$this->legenda."</legend>
    	";
    	
    	if($this->conteudo){
    		foreach($this->conteudo as $conteudo){
    			$div.= $conteudo;
    		}
    	}
    	
    	$div.= "</fieldset></div>";
    	
        return $div;
    }
}
?>
