<?php
class CampoTab
{
	private $conteudo;

	function __construct($tabs = array(), $selecionado = '', $inativas = array()) {
		$this->conteudo = "<div class='grupo_aba'>";
		foreach($tabs as $aba => $link){
			$this->conteudo .= "<div id='".str_replace(" ","_",$aba)."' class='aba";

			if($selecionado == $aba){
				$this->conteudo .= "_selecionada";
			}

			if(in_array($aba, $inativas)){
				$this->conteudo .= "_inativa";
			}

			$this->conteudo .= "'>";

			if(!in_array($aba, $inativas) && !($selecionado == $aba)){
				$this->conteudo .= "<a href='".$link."' >";
			}
			$this->conteudo .= $aba;

			if(!in_array($aba, $inativas) && !($selecionado == $aba)){
				$this->conteudo .= "</a>";
			}

			$this->conteudo .= "</div>";
		}
		$this->conteudo .= "</div><div style='clear: both'></div>";

	}

	public function toHTML() {
		return $this->conteudo." <br />";
	}
}
?>