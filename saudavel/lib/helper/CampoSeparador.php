<?php
class CampoSeparador extends Artefato
{
    function __construct($width = '15px', $height = '27px') {
		$this->conteudo = "<p style='width:".$width."; height:".$height."'/>";
    }
}
?>