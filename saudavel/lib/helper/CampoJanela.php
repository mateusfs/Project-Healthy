<?php
class CampoJanela
{
	protected $id;
	protected $conteudo;
	protected $tituloJanela;
	protected $iconJanela;
	protected $actionJanela;
	protected $targetJanela;
	protected $modulo;
	protected $width;
	protected $addOpcao;
	protected $widthOpcao;
	protected $pagRemoveBox;
	protected $errors;
	protected $success;
	
    function __construct($titulo, $id, $action, $width = 600, $icon = 'window.png', $target = '_self') {
        $this->conteudo = array();
		$this->addOpcao = array();
		$this->tituloJanela = $titulo;
		$this->id = $id;
		$this->iconJanela = $icon;
		$this->actionJanela = $action;
		$this->targetJanela = $target;
		$this->width = $width;
		$this->pagRemoveBox = null;
    }
    
    public function setSuccess($success = array()){
    	$this->success = $success;
    }
    
    public function getSuccess(){
    	return $this->success;
    }
    
    public function setErrors($errors = array()){
    	$this->errors = $errors;
    }
    
    public function getErrors(){
    	return $this->errors;
    }

    public function addConteudo($conteudo = null) {
		if(!is_null($conteudo))
			$this->conteudo[] = $conteudo;
    }

	public function addPagRemoveBox($pag, $callback = ''){
		$this->pagRemoveBox = ", '".$pag."', '".$callback."'";
	}

	public function addOpcao($conteudo = null){
		if(!is_null($conteudo))
			$this->addOpcao[] = $conteudo;
	}

    public function toHTML() {
    	
    	
    	
        $janela = "
			<div class='janela' style='width:{$this->width}px;'>
				";
				
        		if($this->iconJanela){
					$janela .= "<div class='icone_janela'><img width='32' title='".$this->tituloJanela."' src='../web/img/icon/".$this->iconJanela."' /></div>";
        		}
        		
        		if($this->tituloJanela){
					$janela .= "<div class='titulo_janela'>".$this->tituloJanela."</div>";
        		}
        		
				$janela .= "
				<form id='{$this->id}' action='{$this->actionJanela}' target='{$this->targetJanela}' method='POST' enctype='multipart/form-data'>
					<div id='div_error_{$this->id}' class='error' style='display:none; margin-bottom: 20px'></div>
				";
				
				
				if(!empty($this->errors)){
					$janela .= "<div id='div_error_return' class='error' style='margin-bottom: 20px'>";
					
					if(is_array($this->errors)){
						foreach($this->errors as $err){
							$janela .= "<div>".$err."</div>";
						}
					}else{
						$janela .= "<div>".$this->errors."</div>";
					}
					$janela .= "</div>";
				}
				
				
				if(!empty($this->success)){
					$janela .= "<div id='div_success_return' class='success' style='margin-bottom: 20px'>";
						
					if(is_array($this->success)){
						foreach($this->success as $succ){
							$janela .= "<div>".$succ."</div>";
						}
					}else{
						$janela .= "<div>".$this->success."</div>";
					}
					$janela .= "</div>";
				}
				

		if($this->conteudo){
			foreach($this->conteudo as $conteudo){
				$janela.= $conteudo;
			}
		}

		$janela.= "
					<div style='clear:both;'>
						<br/>
						</div>
				</form>
			</div>
		";

		echo $janela;
    }
}
?>
