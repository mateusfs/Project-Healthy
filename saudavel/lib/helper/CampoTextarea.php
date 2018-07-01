<?php
class CampoTextarea extends Artefato
{
	function __construct($label, $name, $observacao = null, $obrigatorio = false, $param = array()) {

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
		$textarea = '';
		$descricao = '';
		$labelObservacao = '';
		if(count($param) > 0){
			foreach($param as $tipo => $valores){
				$conteudo = '';
				foreach($valores as $atributo => $valor){
					if($tipo == 'textarea' && $atributo == 'value')
						$descricao = $valor;
					else
						$conteudo.= $atributo."=\"{$valor}\"";
				}
				switch($tipo){
					case 'div':
						$div = $conteudo;
						break;
					case 'span':
						$span = $conteudo;
						break;
					case 'textarea':
						$textarea = $conteudo;
						break;
					case 'labelObservacao':
						$labelObservacao = $conteudo;
						break;
				}
			}
		}

		if($observacao){
			$observacao = " <label {$labelObservacao}>({$observacao})</label>";
		}else{
			$observacao = "";
		}

		$this->conteudo .= "
			<div class='div_linha' style='position: relative; height: 80px;' {$div}>
				<div class='linha_descricao'><label  for='{$name}'><span {$span}>".$label . $obrigatorio .": ". $observacao."</span></label></div>
				<div class='linha_campo_input'><textarea class='texto textarea'  style='text-align: left; width: 742px;' name='{$name}' id='{$name}' {$textarea}>{$descricao}</textarea> {$posTexto}</div>
			</div>";
	}

}
?>
