<?php
class CampoHidden
{
	private $conteudo;

    function __construct($name, $value) {

		$this->conteudo = "<input type='hidden' name='{$name}' id='{$name}' value='{$value}'/>";
    }

    public function toHTML() {
        return $this->conteudo;
    }
}
?>
