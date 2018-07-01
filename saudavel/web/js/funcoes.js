/**
 * Inicializa configurações
 */
function init() {
	$.ajaxSetup({
		type: "POST",
		cache: false,
		async: false,
		error: function(html){
			removeBox();
		}
	});

	//definindo o padrão do calendário para portugues
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);

//  $('img, a').tipsy({gravity: 's', live: true});

	$("#loading").bind("ajaxSend", function(){

		$('.tipsy').remove();

		$(this).show();
		}).bind("ajaxComplete", function(){
			$(this).hide();

			//Alinhamento do box_conteudo
			if ($('#box_conteudo').exists()) {
				$("#box_conteudo").css({
					width: $("#box_conteudo").children().width()
					, marginLeft: ($("#box_conteudo").children().width()/2) * -1
				});
			}
	});


	$('a').live('click', function(e){

		if ($(this).attr('target') || ($(this).attr('href') == 'jcmsw')) {

			if ($(this).attr('target') != '_blank') {
				e.preventDefault();

				if($(this).attr('href') == 'jcmsw')
					return false;

				loadPage($(this).attr('href'), $(this).attr('target'));
			}

		}
	});


	$(':reset').live('click', function(e){
		e.preventDefault();

		$(this).parents('form').trigger('reset');
		$(this).parent().parent().prev().prev().children().children().trigger('click');
	});


	$('.funcaoBusca').live('click blur', function(e){
		if(e.type == 'click'){
			if($(this).val() == $(this).attr('lang'))
				$(this).val("");
		}else{
			if($(this).val() == "")
				$(this).val($(this).attr('lang'));
		}
	});


	$('li.headlink').hover(
		function() {$('ul', this).css('display', 'block');},
		function() {$('ul', this).css('display', 'none');});

	$('#cssdropdown li.headlink').hover(
		function() {$(this).css('background-color', '#6D86B7');},
		function() {$(this).css('background-color', '#627aad');});


	$('.janela').live('mouseover mouseout', function(e){
		$(this).find('img').each(function(){
			if(e.type == 'mouseover') {
				//iconBoxToggle($(this), true);
			} else {
				//iconBoxToggle($(this), false);
			}
		});

	});

	$('table.JCMSW_grid tbody tr').live('mouseover mouseout', function(e){
		if(e.type == 'mouseover')
			$(this).css('background', '#ECEFF5');
		else
			$(this).css('background', '#ffffff');
	});


	$(".tabelaFotos ul li").live('mouseenter mouseleave', function(e){

		$(this).children(".actions").width($(this).children(".actions").next().width());
		$(this).children(".actions").height($(this).children(".actions").next().height());

		$(this).children(".actions").fadeToggle(200);
	});

//	$('.tabelaFotos div.actions').tipsy({live: true, title: 'rel'});
}


/**
 * Faz a validação dos dados
 * @param obj
 * @param modulo
 * @param validator
 * @returns {Boolean}
 */
function validaDados(obj, modulo, validator){
	if(!validator){
		validator = 'validaDados';
	}
	var retornoValidaDados = true;
	var parametros = $(obj).serializeArray();

	$.ajax({
		url: modulo +'/'+validator,
		data: parametros,
		success: function(html){
			if(html){
				showErrors($(obj).attr('id'), html);
				retornoValidaDados = false;
			}
		}
	});
	return retornoValidaDados;
}


/**
 * Mostra div com erros na janela
 * @param id
 * @param msg
 */
function showErrors(id, msg) {
	$('#div_error_'+id)
		.html(msg)
			.css('display', 'block')
				.delay(2000)
					.fadeOut('slow');
}


/**
 * Mostra modalzinho com mensagem no rodapé
 * @param mensagem
 * @param tipo
 * @param delay
 */
function showMessage(mensagem, tipo, delay) {
	if(!tipo){
		tipo = 0;
	}

	if(!delay){
		delay = 2000;
	}

	var tipoMensagem = new Array();
	tipoMensagem[0] = 'success';
	tipoMensagem[1] = 'info';
	tipoMensagem[2] = 'warning';
	tipoMensagem[3] = 'error';

	$(document.createElement("div"))
		.attr("id", "boxSucess")
			.addClass(tipoMensagem[tipo] + ' boxSucess')
					.prependTo($(document.body));

	$("#boxSucess").html(mensagem).fadeIn("slow", function(){
		setTimeout(function() {
			$(".boxSucess").each(function(){
				$(this).fadeOut(function(){
					$(this).remove();
				});
			});
		}, delay);
	});
}


/**
 * Remove a janela
 * @param event
 * @param page
 * @param callback
 */
function removeBox(event, page, callback) {

	$('.tipsy').remove();

	var win;
	if (event == undefined || !event) { //considera a janela atual
		win = $("#box_conteudo");
	} else { //considera a janela clicada
		win = $(event.currentTarget).parents("div[id^=box_conteudo]");
	}

	if ($('#'+$(win).attr('id')).exists()) {
		$('#'+$(win).attr('id')).remove();

		$('#box').data('windows', ($('#box').data('windows') - 1));

		if ($('#box').data('windows') == 0) {
			$('#box').remove();
			$('#box_' + $('.boxClass').length).attr('id', 'box');
		}


		//RENOMEANDO AS BOX_CONTEUDO PARA ORDENAÇÃO
		var i = 0;
		var total = $(".boxConteudoClass").length;
		$(".boxConteudoClass").each(function(){
			if (i == 0) {
				if($(this).attr('id') != 'box_conteudo') {
					$(this).attr('id', 'box_conteudo');
				}
			} else {
				$(this).attr('id', 'box_conteudo_' + (total - i));
			}

			i++;
		});
		//FIM DA ORDENAÇÃO


		//TRIGGER callback
		if(callback != undefined && callback) {
			eval(callback);
		}

	} else {
		if(page == undefined || !page) {
			page = 'index/home';
		}
		$(location).attr('href', page);
	}
}


/**
 * Mostra a janela
 * @param modal
 */
function showBox(modal) {

	if (modal == undefined) {
		modal = true;
	}

	var zIndex = 10;
	if ($('#box_conteudo').exists()) {
		zIndex = 11;
		$('#box_conteudo').attr('id', 'box_conteudo_' + $('.boxConteudoClass').length);

		if (modal) {
			$('#box').attr('id', 'box_' + $('.boxClass').length);
		}

		zIndex+= ($('.boxConteudoClass').length * 2);
	}

	if (modal) {
		$(document.createElement("div"))
			.attr("id", "box")
				.addClass('boxClass')
					.css({
							opacity:	0.25
							, position: 'fixed'
							, left: 0
							, top: 0
							, width: '100%'
							, height: '100%'
							, zIndex: zIndex
						})
						.prependTo($(document.body));
	}

	$(document.createElement("div"))
		.attr("id", "box_conteudo")
			.addClass('boxConteudoClass')
				.css({zIndex: ++zIndex})
					.prependTo($(document.body));

	if ($('#box').exists() && modal) {
		$('#box').data('windows', 1);
	} else if ($('#box').exists()) {
		var countWindows = $('#box').data('windows');
		countWindows++;
		$('#box').data('windows', countWindows);
	}

	$( "#box_conteudo" ).draggable({
		containment: "parent"
		, cancel: '.tabelaFotos, :input,option' //:input,option são default e se tirar buga os campos
	});
}


/**
 * Mostra icone ativo/inativo no topo da janela
 * @param objImg
 * @param show
 */
function iconBoxToggle(objImg, show) {

	var src = $(objImg).attr('src');

	if (show) {
		$(objImg).attr('src',src.replace('gray_18','color_18'));
	} else {
		$(objImg).attr('src',src.replace('color_18','gray_18'));
	}

}

/**
 * Carrega a página via AJAX
 * @param url
 * @param target
 * @param param
 * @param callback
 */
function loadPage(url, target, param, callback){

	if(target == 'box_conteudo'){
		showBox();
	}
	if(target == 'teste_conteudo'){
		showBox(false);
		target = 'box_conteudo'
	}

	var parametros = null;
	if(param)
		parametros = param;

	$.ajax({
		async: true,
		url: url,
		data: parametros,
		beforeSend: function(){
			$("#"+target).html('<div align="center" style="margin-top: 120px;"><img src="../web/img/loading.gif" alt="loading" title="loading" /><br /><span class="letra_pequena">Carregando...</span></div>');
		},
		success: function(html){
			$('#'+target).html(html);
			if(callback){
				eval(callback);
			}
		}
	});
}

/**
 * Faz a busca na listagem
 * @param obj
 * @param target
 */
function buscaListagem(obj, target) {
	var parametros = $(obj).serializeArray();
	$.ajax({
		url: $(obj).attr('action'),
		data: parametros,
		success: function(html){
			$('#'+target).html(html);
		}
	});
}


/**
 * Salva o registro
 * @param obj
 * @param modulo
 * @param callback
 * @param pagRemoveBox
 * @returns {Boolean}
 */
function salvaRegistro(obj, modulo, callback, pagRemoveBox) {
	if(validaDados(obj, modulo)){
		var parametros = $(obj).serializeArray();

		$.ajax({
			url: $(obj).attr('action'),
			data: parametros,
			success: function(html){
				showMessage(html)

				if(pagRemoveBox){
					removeBox(null, pagRemoveBox);
				}else{
					removeBox();
				}


				if(callback){
					eval(callback);
				}

				if(document.getElementById(modulo + '_list')){
					buscaListagem($('#'+ modulo + '_list'), 'listagem_'+ modulo);
				}
			}
		});

	}
	return false;
}


/**
 * Chama função para validar antes de deletar
 * @param modulo
 * @param parametros
 * @returns {Boolean}
 */
function verificaDelete(modulo, parametros) {
	var retornoValidaDados = true;
	$.ajax({
		url: modulo +'/validaDados.php',
		data: parametros,
		success: function(html){
			if(html){
				$('#div_error_'+ modulo +'_list')
					.html(html)
						.css('display', 'block')
							.delay(2000)
								.fadeOut('slow');
				retornoValidaDados = false;
			}
		}
	});
	return retornoValidaDados;
}


/**
 * Deleta o registro
 * @param url
 * @param parametros
 * @param modulo
 * @returns {Boolean}
 */
function deleteRegistro(url, parametros, modulo) {
	if (!modulo) {
		modulo = null;
	}

	if (modulo) {
		if(!verificaDelete(modulo, parametros)){
			return false;
		}
	}

	if(confirm('Deseja realmente excluir o registro?')){

		var modulo = url.split('/');
			modulo = modulo[0];

		$.ajax({
			url: url,
			data: parametros,
			success: function(html){
				showMessage(html)
				if(document.getElementById(modulo + '_list')){
					buscaListagem($('#'+ modulo + '_list'), 'listagem_'+ modulo);
				}
			}
		});
	}
}


/**
 * Delete a imagem e atualiza a div
 * @param url
 * @param parametros
 */
function deleteFotografia(url, parametros) {
	if(confirm('Deseja realmente excluir a imagem?')){
		$.ajax({
			url: url,
			data: parametros,
			dataType: 'json',
			success: function(json){
				showMessage(json.msg);
				loadPage(json.loadPage.url, json.loadPage.target, json.loadPage.param);
			}
		});
	}
}

/**
 * Enviar as informações em strtotime
 * @param horaInicio1
 * @param horaFim1
 * @param horaInicio2
 * @param horaFim2
 */
function isChoqueHorario(horaInicio1, horaFim1, horaInicio2, horaFim2){
	if( ( horaInicio2 < horaInicio1 && horaFim2 < horaInicio1 ) || (horaInicio2 > horaFim1 && horaFim2 > horaFim1)   ){
		return false;
	}

	return true;
}

/**
 * Mascara
 * @param src
 * @param mask
 */
function formatar(src, mask){
	var i = src.value.length;
	var saida = mask.substring(0,1);
	var texto = mask.substring(i)
	if (texto.substring(0,1) != saida){
		src.value += texto.substring(0,1);
	}
}

jQuery.fn.exists = function () {
	return jQuery(this).length > 0 ? true : false;
};

function number_format( number, decimals, dec_point, thousands_sep ) {
var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
var d = dec_point == undefined ? "," : dec_point;
var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;

return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}
/**
*	Usage: 	number_format(123456.789, 2, '.', ',');
*	result:	123,456.79
**/


function adicionarPessoaGrupo(cdPessoa, nomePessoa){
	event.preventDefault();
	$("#linha_campo_input_grupo").html(nomePessoa);
	$("#cdPesCod").val(cdPessoa);


	$("#helper_search_popup_close").click();
}
function adicionarPessoaUr(cdCodigo, nomeUr){
	event.preventDefault();
	$("#linha_campo_input_pessoaur").html(nomeUr);
	$("#cdCodUr").val(cdCodigo);

	$("#helper_search_popup_close").click();
}


function adicionarUrGrupo(cdUr, nomeUr, cdGrupo){
	event.preventDefault();
	$.ajax({
		url: 'grupour/save',
		type: "POST",
		data: {nomeUr : nomeUr, cdUr:cdUr, cdGrupo: cdGrupo },
		success: function (data){
			if(data == 'Erro2'){
				$(window.document.location).attr("href","grupour/index/codigo/"+cdGrupo+"/erro/2", "tabelaDiv", "", "");
			}else if(data == "OK"){
				$(window.document.location).attr("href","grupour/index/codigo/"+cdGrupo, "tabelaDiv", "", "");
			}

		}
	});

	$("#helper_search_popup_close").click();
}

