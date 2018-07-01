<?php
class CampoListaMenor
{
	protected $width;
	protected $conteudoTHead;
	protected $conteudoTBody;
	protected $paginacao;
	protected $paginador;

    function __construct() {
		$this->conteudoTHead = null;
		$this->conteudoTBody = array();
		$this->paginacao = null;
		$this->paginador = null;
    }

	function addTHead($tds=array(), $param=array()){

		$thead = "<thead><tr>";
		foreach($tds as $indice=>$tdLabel){
			$thead.= "<th ".(isset($param[$indice]) ? $this->arrayToString($param[$indice]) : "")." height='25'>".$tdLabel."</th>";
		}
		$thead.= "</tr></thead>";

		$this->conteudoTHead = $thead;
	}

	function addTBody($tds=array(), $param=array()){

		$tbody = "<tr>";
		foreach($tds as $indice=>$tdLabel){
			$tbody.= "<td ".(isset($param[$indice]) ? $this->arrayToString($param[$indice]) : "")." height='25'>{$tdLabel}</td>";
		}
		$tbody.= "</tr>";

		$this->conteudoTBody[] = $tbody;
	}

	function addPaginacao($pag, $total, $url, $target, $limite = 10){
		
		$url = addslashes($url)."/pagina/";

		$paginador = new Paginador();
		$paginador->setUrl($url);
		$paginador->setTarget($target);
		
		$paginador->setTotalItems($total);
		$paginador->setCurrentPage($pag);
		$paginador->setItemsPerPage($limite);
		
		$this->paginador = $paginador;
		
		$this->paginacao = $paginador->getHtml();

	}

    public function toHTML() {
        $conteudo = "
				<div style='padding-left: 2px; padding-right: 2px;'>
				<table cellpadding='0' cellspacing='2' border='0' width='100%' class='JCMSW_grid'>";

				//INICIO THEAD
				$conteudo.= $this->conteudoTHead;
				// FIM THEAD

				//INICIO TBODY
				if(count($this->conteudoTBody) > 0){
					$conteudo.= "<tbody>";
					for($i=0; $i < count($this->conteudoTBody) ; $i++){
						$conteudo.= $this->conteudoTBody[$i];
					}
					$conteudo.= "</tbody>";
				}
				// FIM TBODY

		$conteudo.= "
				</table>
				</div>
				<div class='JCMSW_grid_paginacao' style='color:#ffffff; font-weight:bold; width:-4px;'>
					{$this->paginacao}
				</div>
		";

		echo $conteudo;
    }

	private function arrayToString($array){
		$string = '';
		if(count($array) > 0){
			foreach($array as $tipo => $valor){
				$string.= $tipo."=\"{$valor}\"";
			}
		}

		return $string;
	}
}
?>
