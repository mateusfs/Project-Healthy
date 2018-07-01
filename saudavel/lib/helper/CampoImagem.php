<?php
class CampoImagem extends Artefato
{
	private $linkImagem;
	private $height;
	private $width;
	
	private $icones;
	
    function __construct($link,$width, $height = '', $icones = array()) {
    	$this->linkImagem = $link;
    	$this->width = $width;
    	$this->height = $height;
    	$this->icones = $icones;
    }
    
    public function toHTML(){
    	$return = '<div class="left" style="margin: 5px 0; width:'.$this->width.'px; ">
			<div class="div_linha" style="width:'.$this->width.'px;" >';
    	
    	$return .= "<img src='".$this->linkImagem."' ";
    	
    	if($this->width){
    		$return .= " width='".$this->width."' ";
    	}
    	
    	if($this->height){
    		$return .= " height='".$this->height."' ";
    	}
    	
    	$return .= "/>";	
    	
    	foreach($this->icones as $icone){
    		$return .= "<div style='text-align: center;'><a href='".$icone['link']."' ".$icone['outro']." class='".$icone['class']."'  ><img title='".$icone['titulo']."' src='".$icone['img']."' /></a></div>";
    	}
    	
    	$return .= '</div></div>';
    	return $return;
    }

}
?>