<?php
class CampoSelect extends Artefato
{
	function __construct($label, $name, $observacao = null, $obrigatorio = false, $opcoes = array(), $selected = null, $param = array(), $style = '') {

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
		$select = '';
		$labelObservacao = '';
		$strSelected = '';
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
					case 'select':
						$select = $conteudo;
						break;
					case 'labelObservacao':
						$labelObservacao = $conteudo;
						break;
				}
			}
		}

		if($observacao){
			$observacao = " <label for='{$name}' {$labelObservacao}>({$observacao})</label>";
		}else{
			$observacao = "";
		}

		$this->conteudo .= "
		<div class='div_linha' style='height: 22px; {$style}' {$div}>
		<div class='linha_descricao' ><label for='{$name}'><span {$span}>".$label . $obrigatorio . $observacao." :</span></label></div>
		<div class='linha_campo_select'><select class='select' name='{$name}' id='{$name}' {$select}>
		";

		if(is_array($opcoes)){
			foreach($opcoes as $id => $value){
				if($selected == $id){
					$strSelected = ' selected="selected"';
				}else{
					$strSelected = '';
				}

				$this->conteudo .= "
				<option value='".$id."' $strSelected >".$value."</option>";
			}
		}
		$this->conteudo .= "
		</select></div>
		</div>";
	}

}
?>
