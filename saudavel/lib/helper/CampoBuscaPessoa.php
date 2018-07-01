<?php
class CampoBr
{
	private $conteudo;

    function __construct($tipo = 'all') {
		$this->conteudo = "<br clear='{$tipo}'/>";
    }

    public function toHTML() {
        return $this->conteudo;
    }
}
?>