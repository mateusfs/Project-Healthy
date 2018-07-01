<?php
class CampoCheckList extends Artefato
{
	function __construct($label, $name, $valores = array(), $selected = array(), $observacao = false, $obrigatorio = false) {

		$id = str_replace('[]','',$name);

		if($obrigatorio){
			$obrigatorio = " <label style='color: red'>*</label>";

			$this->conteudo = "
				<script type='text/javascript'>
				$(document).ready(function (){
					var id = arrayObrigatorios.length + 1;
					arrayObrigatorios[id] = new Array();
					arrayObrigatorios[id][1] = '".$id."';
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

		if($observacao){
			$observacao = " <label class='label_observacao' {$labelObservacao} for='{$name}'>({$observacao})</label>";
		}else{
			$observacao = "";
		}

		$this->conteudo .= "
		<div class='div_linha' {$div}>
		<div class='linha_descricao'><label {$span} for='".$id."' ><span {$span}>".$label . $obrigatorio . $observacao." :</span></label></div>
		<div class='linha_campo'>";

		if(sizeof($valores) > 0){
			$i = 0;
			foreach($valores as $valor=>$atributo){

				$selecionado = '';

				if(is_array($selected)){
					foreach($selected as $select){
						if($select == $valor){
							$selecionado = 'checked="checked"';
						}
					}
				}

				$this->conteudo .= "
				<div class='linha_radio'>
				<div class='radio_valor' ><input type='checkbox' ".$selecionado." name='{$name}' id='".$id."_".$i."' value='{$valor}'/></div>
				<div class='radio_atributo' ><label for='".$id."_".$i."'>{$atributo}</label></div>
				</div>";
				$i++;
			}
		}

		$this->conteudo .= "</div>
		</div>";
	}

}
?>