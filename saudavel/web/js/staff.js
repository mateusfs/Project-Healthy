/**
 *
 */
function initTinyMce() {

	$('textarea.tinymce').tinymce({

		// Location of TinyMCE script
		script_url : '../web/components/tiny_mce/tiny_mce.js',
		theme : 'advanced',
		plugins : 'inlinepopups, table,preview',
		language : 'pt',
		dialog_type : 'modal',

		theme_advanced_buttons1:'mybutton,code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,link,unlink,formatselect,fontselect,fontsizeselect,forecolor,backcolor',
		theme_advanced_buttons2 : 'table,tablecontrols,|,visualaid,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,preview',
		theme_advanced_buttons3 : '',
		theme_advanced_buttons4 : '',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_resizing : false

	});

}

/**
 *
 * @param urlBase
 * @param modulo
 * @param action
 * @param objParam
 */
function initPlUpload(urlBase, modulo, action, objParam) {

	var sep = '';
	var objParamStr = '';
	$.each(objParam, function(i, v) {
		objParamStr+= sep + i + '=' + v;
		sep = '&';
	});


	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		//runtimes : 'flash',
		browse_button : 'pickfiles',
		container : 'container',
		max_file_size : '10mb',
		url : urlBase + 'staff/'+ modulo +'/uploadMultiplo',
		flash_swf_url : urlBase + 'web/components/plupload/js/plupload.flash.swf',
		silverlight_xap_url : urlBase + 'web/components/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : 'Imagens', extensions : 'jpg,gif,png'}
		]
		, chunk_size : '500kb'
		, multipart_params: objParam
	});

	uploader.bind('Init', function(up, params) {
		//$('#filelist').html('<div>Current runtime: ' + params.runtime + '</div>');
	});

	$('#uploadfiles').click(function(e) {

		if (uploader.files.length) {

			$('#linksUp').hide();
			$('#Xenviados').show();

			uploader.start();

		}
		e.preventDefault();
	});

	$('#'+ modulo +'_list .botao').removeAttr('onclick');
	$('#'+ modulo +'_list .botao').click(function(){
		uploader.stop();
		removeBox();
	});

	uploader.init();

	var soma = 0;
	uploader.bind('FilesAdded', function(up, files) {
		var deyup = parseInt($('#deyup').html());
		$('#deyup').html(deyup+files.length);

		var pad = 4;

		$.each(files, function(i, file) {
			var tmp = '<div id=\"' + file.id + '\" style=\"width: 100%; height:24px; border-bottom: 1px solid #DDDDDD; clear: both\">';
			tmp+= '		<div style=\"float:left; width: 72%; padding-top: '+pad+'px; padding-bottom: '+pad+'px;\">'+file.name+'</div>';
			tmp+= '		<div style=\"float:left; width: 18%; text-align:center; padding-top: '+pad+'px; padding-bottom: '+pad+'px;\">'+plupload.formatSize(file.size)+'</div>';
			tmp+= '		<div style=\"float:left; width: 10%; text-align:center; padding-top: '+pad+'px; padding-bottom: '+pad+'px; color: #777777\"><label>0%</label></div>';
			tmp+= '</div>';

			$('#filelist').append(tmp);

			soma += file.size;
		});

		$('#tamTotal').html(plupload.formatSize(soma));

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('UploadProgress', function(up, file) {
		$('#' + file.id + ' label').html(file.percent + '%');

		$('#perTotal').html(uploader.total.percent);
	});

	uploader.bind('Error', function(up, err) {
		$('#filelist').append('<div>Error: ' + err.code +
			', Message: ' + err.message +
			(err.file ? ', File: ' + err.file.name : '') +
			'</div>'
		);

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file) {
		$('#' + file.id + ' label').html('100%');
		$('#' + file.id).css('color', '#AAAAAA');

		var xup = parseInt($('#xup').html());
		$('#xup').html(xup+1);
	});

	uploader.bind('UploadComplete', function(up, file) {

		showMessage('Envio multiplo de arquivos finalizado com sucesso.');

		loadPage(action, 'listagem_' + modulo, objParamStr);
	});

}

function checkAll(checkbox){
	$("input[type='checkbox']").not(checkbox).attr('checked', checkbox.checked);

	$.each($("input[type='checkbox']").not(checkbox), function (){
		if($(this).attr('checked') == 'checked'){
			salvaValor($(this).val(), 'add');
		}else{
			salvaValor($(this).val(), 'remove');
		}

	});


}

function salvaSelecionado(checkbox){

	valor = checkbox.value;
	acao = 'add';
	if(checkbox.checked == false){
		acao = 'remove';
	}

	$.ajax({
		url: 'util/salvaSelecionado',
		type: 'POST',
		async: true,
		data: {codigo: valor, acao: acao}
	})
}

function salvaValor(valor, acao){
	$.ajax({
		url: 'util/salvaSelecionado',
		type: 'POST',
		async: true,
		data: {codigo: valor, acao: acao}
	})
}

function limpaTodosSelecionados(){
	$.ajax({
		url: 'util/limpaTodosSelecionados',
		type: 'POST'
	})
}

function checkOne(valor){
	$("input[value='"+valor+"']").attr('checked',!$("input[value='"+valor+"']").attr('checked'));

	acao = 'add';
	if($("input[value='"+valor+"']") == false){
		acao = 'remove';
	}

	$.ajax({
		url: 'util/salvaSelecionado',
		type: 'POST',
		data: {codigo: valor, acao: acao}
	})
}

function toggleFiltro(div, event){
	event.preventDefault();
	$("#"+div).slideToggle('fast', function (){
			$('.texto_filtro:first').focus();
	});
}

function executaFiltro(div, modulo){
	parametros = "";

	inputs = $("#divFiltros :input").not(':input[type=button], :input[type=submit], :input[type=reset]');

	for(i = 0; i < inputs.length; i++){
		if(i!=0){
			parametros += "/";
		}
			parametros += inputs[i].name + "/" + inputs[i].value;
	}

	loadPage(modulo+'/tabela/'+parametros, div);
}

function executaFiltroPessoa(div, modulo, acao){

	if(acao == "" || acao == "undefined"){
		acao = "tabela";
	}

	parametros = "";

	inputs = $("#divFiltrosPessoa :input").not(':input[type=button], :input[type=submit], :input[type=reset]');

	for(i = 0; i < inputs.length; i++){
		if(i!=0){
			parametros += "/";
		}

		parametros += inputs[i].name + "/" + inputs[i].value;
	}

	loadPage(modulo+'/'+ acao + "/" + parametros, div);

}
function executaFiltroPessoaAdm(div, modulo, acao){

	if(acao == "" || acao == "undefined"){
		acao = "tabela";
	}

	parametros = "";

	inputs = $("#divFiltrosPessoaAdm :input").not(':input[type=button], :input[type=submit], :input[type=reset]');

	for(i = 0; i < inputs.length; i++){
		if(i!=0){
			parametros += "/";
		}

		parametros += inputs[i].name + "/" + inputs[i].value;
	}

	loadPage(modulo+'/'+ acao + "/" + parametros, div);

}
function executaFiltroUr(div, modulo, acao){

	if(acao == "" || acao == "undefined"){
		acao = "tabela";
	}

	parametros = "";

	inputs = $("#divFiltrosUr :input").not(':input[type=button], :input[type=submit], :input[type=reset]');

	for(i = 0; i < inputs.length; i++){
		if(i!=0){
			parametros += "/";
		}

		parametros += inputs[i].name + "/" + inputs[i].value;
	}

	loadPage(modulo+'/'+ acao + "/" + parametros, div);

}

function executaFiltroPessoaUr(div, modulo, acao){

	if(acao == "" || acao == "undefined"){
		acao = "tabela";
	}

	parametros = "";

	inputs = $("#divFiltrosPessoaUr :input").not(':input[type=button], :input[type=submit], :input[type=reset]');

	for(i = 0; i < inputs.length; i++){
		if(i!=0){
			parametros += "/";
		}

		parametros += inputs[i].name + "/" + inputs[i].value;
	}

	loadPage(modulo+'/'+ acao + "/" + parametros, div);

}
function executaFiltroAcesso(div, modulo, acao){

	if(acao == "" || acao == "undefined"){
		acao = "tabela";
	}

	parametros = "";

	inputs = $("#divFiltrosAcesso :input").not(':input[type=button], :input[type=submit], :input[type=reset]');

	for(i = 0; i < inputs.length; i++){
		if(i!=0){
			parametros += "/";
		}

		parametros += inputs[i].name + "/" + inputs[i].value;
	}

	loadPage(modulo+'/'+ acao + "/" + parametros, div);

}

function executaLimpa(modulo){

	$('#divFiltros select option[selected=selected]').attr('selected',true);

	inputs = $("#divFiltros :input").not(':input[type=button], :input[type=submit], :input[type=reset], select');

	for(i = 0; i < inputs.length; i++){
			inputs[i].value = '';
	}

	limpaTodosSelecionados();

	loadPage(modulo+'/tabela/', 'tabelaDiv');
}

$(document).ready(function () {
	$('.texto_filtro, .select').keypress(function (ev){
		if(ev.keyCode == 13){
			ev.preventDefault();
			$("#filtrar").click();
		}
	});


	$(".evento").mouseenter(function(){
		$(".evento").stop();
		$(this).css('opacity', 1);
		$(".evento").not(this).fadeTo('fast', 0.3);
	});

	$(".evento").mouseleave(function(){
		$(".evento").stop();
		$(".evento").not(this).fadeTo('fast', 1);
	});

	// Declaracao de array usado para validar campos obrigatorios
	arrayObrigatorios = new Array();

});

function alteraIcone(img, status){
	if(status == 'active'){
		img.src = '../web/img/icon/inactive.png';
	}else{
		img.src = '../web/img/icon/active.png';
	}
}

function alteraIconeSair(img, status){
	if(status == 'active'){
		img.src = '../web/img/icon/active.png';
	}else{
		img.src = '../web/img/icon/inactive.png';
	}
}

function checkSubmit(){
	var success = true;
	var formid = '';
	var mensagem = '';

	jQuery.each(arrayObrigatorios, function(index){
										var element = jQuery(':input[name^=' + this[1] + ']');
										if(element.length > 0){

											if(formid == ''){
												formid = element.parents('form').attr('id');
											}

											var type = element.attr('type');

											if(type == 'radio' || type == 'checkbox'){
												var checked = jQuery(':input[name^=' + selector + ']:checked');

												if(checked.length == 0){
													mensagem = mensagem + 'O campo \'' + this[2] + '\' é obrigatório e precisa ser preenchido!<br>';
													success = false;
												}
											}else{
												if(element.val() == ''){
													mensagem = mensagem + 'O campo \'' + this[2] + '\' é obrigatório e precisa ser preenchido!<br>';
													success = false;
												}
											}
										}
									});
	if(success == false){
		mensagem = mensagem.substring(0, mensagem.length - 4);
		showErrors(formid, mensagem);
	}

	return success;
}


function validateEmail(email) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

// Funções Númericas
(function($){

	$.fn.alphanumeric = function(p) {

		p = $.extend({
			ichars: "!@#$%^&*()+=[]\\\';,/{}|\":<>?~`.- ",
			nchars: "",
			allow: ""
		}, p);

		return this.each
			(
				function()
				{

					if (p.nocaps) p.nchars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					if (p.allcaps) p.nchars += "abcdefghijklmnopqrstuvwxyz";

					s = p.allow.split('');
					for ( i=0;i<s.length;i++) if (p.ichars.indexOf(s[i]) != -1) s[i] = "\\" + s[i];
					p.allow = s.join('|');

					var reg = new RegExp(p.allow,'gi');
					var ch = p.ichars + p.nchars;
					ch = ch.replace(reg,'');

					$(this).keypress
						(
							function (e)
								{

									if (!e.charCode) k = String.fromCharCode(e.which);
										else k = String.fromCharCode(e.charCode);

									if (ch.indexOf(k) != -1) e.preventDefault();
									if (e.ctrlKey&&k=='v') e.preventDefault();

								}

						);

					$(this).bind('contextmenu',function () {return false});

				}
			);

	};

	$.fn.numeric = function(p) {

		var az = "abcdefghijklmnopqrstuvwxyz";
		az += az.toUpperCase();

		p = $.extend({
			nchars: az
		}, p);

		return this.each (function()
			{
				$(this).alphanumeric(p);
			}
		);

	};

	$.fn.alpha = function(p) {

		var nm = "1234567890";

		p = $.extend({
			nchars: nm
		}, p);

		return this.each (function()
			{
				$(this).alphanumeric(p);
			}
		);

	};

})(jQuery);
