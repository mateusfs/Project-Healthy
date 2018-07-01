<?php
class CampoDiv
{
	private $conteudo;
	private $id;
	private $param;

    function __construct($id, $param = array()) {
    	$this->param = $param;
    	$this->id = $id;
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
    	
    	$div = "<div id='{$this->id}' {$attr}>";
    	
    	if($this->conteudo){
    		foreach($this->conteudo as $conteudo){
    			$div.= $conteudo;
    		}
    	}
    	
    	$div.= "</div>";
    	
        return $div;
    }
}
?>
