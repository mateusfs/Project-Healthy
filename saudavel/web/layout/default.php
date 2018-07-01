<?php

$__settings = $this->getConfig($this->getApp());

$__arrHEAD = $__settings['head'];
$__arrCss  = $__settings['css'];
$__arrJS   = $__settings['javascript'];



$__title 		= $__arrHEAD['title'];
$__description 	= $__arrHEAD['description'];
$__keywords 	= $__arrHEAD['keywords'];



$__htmlCSS = "";


foreach ($__arrCss as $__cssFile) {
	$__htmlCSS.= "<link href='../".$__cssFile."' type='text/css' rel='stylesheet'>\n";
}

$__htmlJS = "";
foreach ($__arrJS as $__jsFile) {
	$__htmlJS.= "<script src='../".$__jsFile."' type='text/javascript'></script>\n";
}

echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
<meta charset='iso-8859-1'>
<meta name='robots' content='noindex,nofollow'/>
<title>".$__title."</title>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta name='description' content='".$__description."'/>
<meta name='keywords' content='".$__keywords."'/>
<base href='".$this->getConfig(Saud::WWW_BASE).$this->getApp()."/'/>
<link rel='icon' href='../".$this->getConfig('favicon')."' type='image/x-icon'/>
".$__htmlCSS."
".$__htmlJS."
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>
<script type='text/javascript' src='../web/js/jquery.metadata.js'></script>
<script type='text/javascript' src='../web/js/jquery.ImageOverlay.js'></script>
</head>
<body>
<div id='conteudo'>
<div class='divHome'></br></br></br>
	<font size='10'>Saudavel</font>
</div>
<div class='divMenu'>
	<div class='menu_categories'>
		<ul class='dropdown-menu'>
			<li>
				<a href='index'><span>Inicio</span></a>
			</li>
			<li>
				<a href='index'><span>Produtos</span></a>
			</li>
			<li>
				<a href='index'><span>Cardapio</span></a>
			</li>
			<li>
				<a href='index'><span>Sobre</span></a>
			</li>
			<li>
				<a href='index'><span>Categorias</span></a>
			</li>
			<li>
				<a href='index'><span>Ajuda</span></a>
			</li>
	</div>
</div>		
		
		
";
include ($path);
echo "			</div>
<div id='rodape'>
<div id='rodape_texto'>
:: Saudavel © 2014 ::
</div>
</div>
";

$javascript = "
$(document).ready(function(){
init();
});
";
echo Funcoes::javascript($javascript);

echo "		</body>
</html>";