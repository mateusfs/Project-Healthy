<?php
class Artefato {
	
	protected $conteudo;
	
	function __construct() {
	}
	
	public function toHTML() {
		return "<div class='left' style='margin: 5px 0;'>".$this->conteudo."</div>";
	}
}