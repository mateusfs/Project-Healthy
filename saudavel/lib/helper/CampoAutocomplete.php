<?php
class CampoAutocomplete extends Artefato
{
	
	function __construct($label, $name, $url, $destinoData,  $options = array(), $observacao = false, $obrigatorio = false, $param = array()) {

		if($obrigatorio){
			$obrigatorio = " <label style='color: red'>*</label>";
		}else{
			$obrigatorio = "";
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
			$observacao = " <label class='label_observacao' for='{$name}' {$labelObservacao}>({$observacao})</label>";
		}else{
			$observacao = "";
		}

		$this->conteudo = "
		<div class='div_linha' {$div}>
		<div class='linha_descricao'><label  for='{$name}'><span {$span}>".$label. $obrigatorio .": ". $observacao."</span></label></div>
		<div class='linha_campo_input'><input class='texto' type='text' style='text-align: left;' name='{$name}' id='{$name}' {$input}/> {$posTexto}</div>
		</div>";

		$this->conteudo .= "
		<script type='text/javascript'>
		$(document).ready(function (){
		options = { ";
			
		$this->conteudo .= "};
		 options = {
		 	serviceUrl:'".$url."',";
		if(is_array($options)){
			foreach($options as $opcao => $valor){
				$this->conteudo .= $opcao.":".$valor.",";
			}
		}
		$this->conteudo .= "
	 		onSelect: function(value,data){ $('#".$destinoData."').val(data) },
	 		minChars:3,
	 		deferRequestBy: 0 
			};
		a = $('#".$name."').autocomplete(options);
	});
	</script>
	";

	}

}
?>