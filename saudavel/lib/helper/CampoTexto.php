<?php
class CampoTexto extends Artefato
{


	function __construct($label, $name, $observacao = false, $obrigatorio = false, $param = array(), $posTexto = '', $mascara = '', $isPreco = false) {

		if($mascara || $obrigatorio){
			$this->conteudo = "
					<script type='text/javascript'>
					$(document).ready(function (){
					";

			if($mascara){
				$this->conteudo .= "
						$('#".$name."').mask('".$mascara."');
								";
			}

			if($obrigatorio){
				$this->conteudo .= "
						var id = arrayObrigatorios.length + 1;
						arrayObrigatorios[id] = new Array();
						arrayObrigatorios[id][1] = '".$name."';
								arrayObrigatorios[id][2] = '".$label."';
										";
			}

			$this->conteudo .= "
		});
					</script>
					";
		}

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
					case 'divLinhaDescricao':
						$divLinhaDescricao = $conteudo;
						break;
				}
			}
		}

		if($observacao){
			$observacao = " <label class='label_observacao' for='{$name}' {$labelObservacao}>({$observacao})</label>";
		}else{
			$observacao = "";
		}

		$this->conteudo .= "
		<div class='div_linha' {$div}>
		<div class='linha_descricao' {$divLinhaDescricao}><label  for='{$name}'><span {$span}>".$label . $obrigatorio .": ". $observacao."</span></label></div>
		<div class='linha_campo_input'><input class='texto' type='text' style='text-align: left;' name='{$name}' id='{$name}' {$input}/> {$posTexto}</div>
		</div>";

		if($isPreco){
			$this->conteudo .=
			"<script type='text/javascript'>
			$(document).ready(function (){
			$('#{$name}').maskMoney({thousands:'.', decimal:','});
		});
		</script>";
		}
	}

}
?>