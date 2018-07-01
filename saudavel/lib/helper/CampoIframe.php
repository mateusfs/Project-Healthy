<?php
class CampoIframe
{
	private $conteudo;

    function __construct($id, $debug = false, $param = array()) {

		$iframe = '';
		if(count($param) > 0){
			foreach($param as $tipo => $valores){
				foreach($valores as $atributo => $valor){
					$iframe.= $atributo."=\"{$valor}\"";
				}
			}
		}

		if ($debug) {
			$debug = "frameborder='1' width='600' heigh='800'";
		} else {
			$debug = "frameborder='0' width='0' heigh='0'";
		}

		$this->conteudo = "<iframe {$debug} name='{$id}' id='{$id}' {$iframe}></iframe>";
    }

    public function toHTML() {
        return $this->conteudo;
    }
}
?>