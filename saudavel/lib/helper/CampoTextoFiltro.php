<?php
class CampoTextoFiltro extends Artefato
{


	function __construct($label, $name, $observacao = false, $param = array(), $posTexto = '', $mascara = '') {

		$div = '';
		$span = '';
		$input = '';
		$labelObservacao = '';
		if(count($param) > 0){
			foreach($param as $tipo => $valores){
				$conteudo = '';
				foreach($valores as $atributo => $valor){
					$conteudo.= $atributo."=\"{$valor}\"";
				}
				switch($tipo){
					case 'div':
						$div = $conteudo;
						break;
					case 'span':
						$span = $conteudo;
						break;
					case 'input':
						$input = $conteudo;
						break;
					case 'labelObservacao':
						$labelObservacao = $conteudo;
						break;
				}
			}
		}

		if($observacao){
			$observacao = " <label class='label_observacao' for='{$name}' {$labelObservacao}>({$observacao})</label>";
		}else{
			$observacao = "";
		}

		$this->conteudo = "
			<div class='div_linha' {$div}>
				<div class='linha_descricao'><label  for='{$name}'><span {$span}>".$label. $observacao." :</span></label></div>
				<div class='linha_campo_input'><input class='texto_filtro' type='text' style='text-align: left;' name='{$name}' id='{$name}' {$input}/> {$posTexto}</div>
			</div>";
	}

}
?>