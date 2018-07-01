<?php
class CampoFile extends Artefato
{
	function __construct($label, $name, $observacao = false, $obrigatorio = false, $param = array(), $posTexto = '') {

		if($obrigatorio){
			$obrigatorio = " <label style='color: red'>*</label>";

			$this->conteudo = "
				<script type='text/javascript'>
				$(document).ready(function (){
					var id = arrayObrigatorios.length + 1;
					arrayObrigatorios[id] = new Array();
					arrayObrigatorios[id][1] = '".$name."';
					arrayObrigatorios[id][2] = '".$label."';
				});
				</script>
				";
		}else{
			$obrigatorio = "";
			$this->conteudo = "";
		}


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
			$observacao = " <label class='label_observacao' {$labelObservacao}>({$observacao})</label>";
		}else{
			$observacao = "";
		}

		$this->conteudo .= "
			<div class='div_linha' {$div}>
				<div class='linha_descricao'><label  for='{$name}'><span {$span}>".$label . $obrigatorio . $observacao." :</span></label></div>
				<div class='linha_campo_input'><input class='texto' type='file' style='text-align: left; height: 22px;' name='{$name}' id='{$name}' {$input}/> {$posTexto}</div>
			</div>";
	}

}
?>
