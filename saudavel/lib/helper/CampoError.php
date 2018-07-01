<?php
class CampoError
{
	private $conteudo;

    function __construct($modulo, $param = array()) {

		$this->conteudo = "<div id='div_error_{$modulo}' class='error' style='display:none;'></div>";
    }

    public function toHTML() {
        return $this->conteudo;
    }
}
?>
