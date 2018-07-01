<?php
class CampoPopupAjax extends Artefato
{
	/**
	 * 
	 * @param unknown_type $label
	 * @param unknown_type $name
	 * @param unknown_type $options As opções relativas ao autocomplete. Obrigatório:
	 * @param unknown_type $observacao
	 * @param unknown_type $obrigatorio
	 * @param unknown_type $param
	 */
	private $label;
	private $name;
	private $options;
	private $param;
	
	public function __construct($label, $options = array(), $param = array()) {
	
		$this->label = $label;
		$this->options = $options;
		$this->param = $param;
	
	}
	
	public function addConteudo($conteudo = null) {
		if(!is_null($conteudo))
			$this->conteudo[] = $conteudo;
	}
	
	public function toHTML() {
		 
		$attr = '';
		if(count($this->param) > 0){
			foreach($this->param as $tipo => $valores){
				foreach($valores as $atributo => $valor){
					$attr.= $atributo."=\"{$valor}\"";
				}
			}
		}
		 
		$div .= " 
			<a class='botao_link' id='helper_btn_open_popup' href='#'>".$this->label."</a>
			<div id='helper_search_popup_background_black'></div>
			<div id='helper_search_popup'>
				<div id='helper_search_popup_barra'>
					<div id='helper_search_popup_name'>".$this->label."</div>
					<div id='helper_search_popup_close'>
						<a href='#' id='helper_search_popup_close'><img src='../web/img/icon/small_close.png' /></a>
					</div>
				</div>
				<div class='clear'></div>
				<div id='helper_search_popup_content'>";
		
		if($this->conteudo){
			foreach($this->conteudo as $conteudo){
				$div.= $conteudo;
			}
		}
		
		$div .= "
				</div>
			</div>
			<div class='clear'></div>
		";
		
		$div .= "<script type='text/javascript'>
		$(document).ready(function (){
			$('#helper_btn_open_popup').click(function (event){
				event.preventDefault();
				$('#helper_search_popup_background_black').fadeToggle('fast', function() { 
					$('#helper_search_popup').fadeToggle('fast');
				});
			});
			
			$('#helper_search_popup_close').click(function (event){
				event.preventDefault();
				$('#helper_search_popup').fadeToggle('fast', function (){
					$('#helper_search_popup_background_black').fadeToggle('fast');	
				});				
			});
		});
		</script>
		";
		
		return $div;
	}

}
?>