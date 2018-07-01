<?php
class CampoObservacao extends Artefato
{
    function __construct($text) {
		$this->conteudo = "<span class='alert' >".$text.'</span>';
    }
}
?>