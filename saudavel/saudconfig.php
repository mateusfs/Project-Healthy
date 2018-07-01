<?php

define("FOLDER_BOLETO_IMG", "../../web/img/boleto/imagens");

$__jquery = "web/js/jquery-1.8.0.min.js";


$settings = array(

		'domain' => 'saudavelsc.com.br/saudavel'

		, 'debug' => TRUE

		//DEFAULT
		, 'default'	=> array(

				'head' => array(
						'title' => 'Saudavel'
						, 'description' => ''
						, 'keywords' => ''
				)
				, 'css' => array(
						'web/css/staff.css',
						'web/css/datepicker.css',
						'web/css/helper_popupajax.css',
						'web/css/colorpicker.css',
						'web/css/jquery.treeview.css',
						'web/css/ImageOverlay.css'
				)
				, 'javascript' => array(
						$__jquery
						, 'web/js/jquery-ui-1.8.23.custom.min.js'
						, 'web/js/jquery.ui.datepicker-pt-BR.js'
						, 'web/js/jquery.autocomplete.js'
						, 'web/js/funcoes.js'
						, 'web/js/staff.js'
				)
		)

		//ADM
		, 'adm'	=> array(

				'head' => array(
						'title' => 'Saudavel Administrador'
						, 'description' => ''
						, 'keywords' => ''
				)
				, 'css' => array(
						'web/css/staff.css',
						'web/css/datepicker.css',
						'web/css/helper_popupajax.css',
						'web/css/colorpicker.css'
				)
				, 'javascript' => array(
						$__jquery
						, 'web/js/jquery-ui-1.8.23.custom.min.js'
						, 'web/js/jquery.ui.datepicker-pt-BR.js'
						, 'web/js/jquery.autocomplete.js'
						, 'web/js/funcoes.js'
						, 'web/js/staff.js'
				)
		)
);
