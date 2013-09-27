// JavaScript Document



var endereco_padrao_ajax = dir_cms_htm_root + 'ajax.php';
var validate;

//_____________________________________________

$(document).ready(init_cms);

function init_cms() { //inicializa todas as ações necessárias no load da página

	if(document.getElementById('menusup')) {
		DynarchMenu.setup('menusup', {electric: true});
	}
	
	// CEE-box
	$(".ceebox").ceebox();
	
	$('.bt_ico_off, .ico_view_off').click(function(event) {
		event.preventDefault();
	});
	
	$( ".datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});; // the time format which will be input to the datepicker field upon selection. more info on formatting here: http://docs.jquery.com/UI/Datepicker/formatDate
	$( ".datetimepicker" ).datetimepicker({dateFormat: 'dd/mm/yy'});//{dateFormat: 'dd/mm/yy hh:ii'});; // 


	// Dialog alerta
	$('#dialog_alerta').dialog({
		autoOpen: false,
		width: 300,
		resizable: false,
		modal: true,
		buttons: {
			"OK": function() { 
				$(this).dialog("close"); 
			}
		}
	});


	// Dialog confirma
	var url_confirma = null;
	$("#dialog_confirma").dialog({ 
		autoOpen: false,
		width: 300,
		resizable: false,
		modal: true,
		buttons: { 
			"Sim": function() {
				$(this).dialog("close"); 
				location.href = url_confirma;
			} , 
			"Não": function() { 
				$(this).dialog("close");return false;
			}
		} 
	});


	//hover dos botões
	$('.bt_padrao').hover(
		function() {$(this).addClass('ui-state-hover');}, 
		function() {$(this).removeClass('ui-state-hover');}
	);
	// */

	$('.ico_del').not('.bt_ico_off').click(function(event) {
		event.preventDefault();
		url_confirma = $(this).attr('href');
		confirma('Você tem certeza de que deseja excluir este item?');
		$(this).removeClass('ui-state-hover')
	});

	
	// inicia o DataTable padrão (ordem ascendente da 2ª coluna)
	$('.tb_dados').dataTable({
		"bJQueryUI": true,
		"aaSorting": [[1,'asc']],
		"sPaginationType": "full_numbers"
	});

	// inicia o DataTable (ordem descendente da 2ª coluna)
	$('.tb_dados_desc').dataTable({
		"bJQueryUI": true,
		"aaSorting": [[1,'desc']],
		"sPaginationType": "full_numbers"
	});
	
	
	$('#inverte_sel_unidades').bind('click', function(event) {
		event.preventDefault();
		$('.check_unidades').each(function() {
			$(this).attr('checked', !$(this).attr('checked'));
		});
	});
	
	
	
	// Listener para mudar o perfil de tablóides (preencher checkboxes de unidades)
	$('#perfil_tabloide select').bind('change', preencheUnidades);
}

//_____________________________________________


function preencheUnidades() {
	
	var id_perfil = $(this).val();
	
	if(id_perfil!='') { //alert('$(this).val(): ' + $(this).val());
		show_loading($(this));
		var checks = $(this).parent().siblings('div').find('input'); //alert($(checks).length);
		// limpa todos os checkboxes selecionados
		$(checks).attr('checked', false);
		
		// Chama a lista de unidades do perfil
		var parametros  = "classe=UsuarioCMS&metodo=get_perfil_tabloides";
			parametros += "&id_perfil=" + id_perfil;
			
		$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno= erro==0 ? eval(dados[1]) : dados[1];
			
			if(erro==0) { 
				$.each(mensagem_retorno, function() {
					$('#unid_' + this).attr('checked', true);
				});
			} else {
				alert(mensagem_retorno);
			}
			hide_loading();
		}});	
		//______________*/
	}
	return false;
}





/*
 *Abre o litebox com a imagem para crop
 **/
function editarImagem(campo)
{
	var idArquivo = $(campo).val();
	var escala = $(campo).attr('escala');
	var pagina = "<a href='"+dir_cms_htm_root + "/ferramentas/crop_imagem.php?id="+idArquivo+"&escala="+escala+"' rel='iframe'>editar imagem</a>";
	$.fn.ceebox.popup(pagina,{onload:true,width:800,height:800,html:true,iframe:true});
}


function trim(inputString) {
   // Removes leading and trailing spaces from the passed string. Also removes
   // consecutive spaces and replaces it with one space. If something besides
   // a string is passed in (null, custom object, etc.) then return the input.
   if (typeof inputString != "string") {return inputString;}
   var retValue = inputString;
   var ch = retValue.substring(0, 1);
   while (ch == " ") { // Check for spaces at the beginning of the string
      retValue = retValue.substring(1, retValue.length);
      ch = retValue.substring(0, 1);
   }
   ch = retValue.substring(retValue.length-1, retValue.length);
   while (ch == " ") { // Check for spaces at the end of the string
      retValue = retValue.substring(0, retValue.length-1);
      ch = retValue.substring(retValue.length-1, retValue.length);
   }
   while (retValue.indexOf("  ") != -1) { // Note that there are two spaces in the string - look for multiple spaces within the string
      retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length); // Again, there are two spaces in each of the strings
   }
   return retValue; // Return the trimmed string back to the user
} // Ends the "trim" function


function confere_email(elementValue)
{
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	return emailPattern.test(elementValue);
}

function limpa_retorno_ajax(retorno) 
{
	retorno=retorno.replace(/\+/g," ");
	return unescape(retorno);
}

function checar(form){
    msg='';
    validate = configValidate(form);    
	//console.log(validate.form());
    if(validate.form()){
	return true;
    }
    return false;
}

var msg='';
function configValidate(form){
    var validator =  $(form).validate({
			errorPlacement: function(error, element)
			{
			    if(msg==''){
				$("#dialog_alerta").dialog({
					close: function(event, ui) {
						$(element).focus();
						// mantém destacado por 3 segundos
						$(element).addClass('campo_obr_foco');
						window.setTimeout(function() {$(element).removeClass('campo_obr_foco');}, 3000);
					}
				});

				var erro = $(error[0]).text();
				var campo = $(element).siblings('label').find('span').text();
				 msg += erro.replace('#campo#', "<strong>"+campo+"</strong>");
				alerta(msg);
			    }
			},
		    onfocusin:false,
		    onkeyup:false,
		    onfocusout:false
    })
    return validator;
}

function alerta(msg) {
	$("#dialog_alerta p").html(msg);
	$("#dialog_alerta").dialog("open");
}



function confirma(msg) {
	$("#dialog_confirma p").html(msg);
	$("#dialog_confirma").dialog("open");
}

function dialog_fechar() {
	$( "#dialog" ).dialog( "close" );
	
	return false;
}

var campo_focado=null;
function foca_campo() {
	if(campo_focado) {
		window.setTimeout(function() {
			$(campo_focado).removeClass('campo_obr_foco');
			campo_focado=null;
		}, 1500);
		$(campo_focado).focus();
	}
}

function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}


function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}


/*________________________________________________________*/


function submete_login() { //alert('submete_login');
	if($('#enviar').val()==2) {
		return submete_reenvio();
	} else {
		show_loading('#bt_submete_login');
		
		//var box = $('#result_login');
		//$(box).fadeIn();
		formulario = document.getElementById('form_login');
		
		if(!checar(formulario)) {
			hide_loading();
		} else {
			//alert('passou'); return false;
	
			var email = $('#login_email').val(); 
			var senha = $('#login_senha').val(); 
			
			var parametros  = "classe=Authenticate&method=submete_login";
				parametros += "&email=" + email;
				parametros += "&senha=" + senha;
			
			$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
				var dados=eval(limpa_retorno_ajax(retorno));
				var erro=dados[0];
				var mensagem_retorno=dados[1];
				
				if(erro==0) { 
					//alert(mensagem_retorno);
					setCookie('ultimo_email_login',mensagem_retorno,30); // cria um cookie com o último e-mail bem sucedido --> para preencher o campo na próxima vez
					location.href = 'home.php';
				} else {
					hide_loading();
					switch (erro)
					{
						case 1:
							var campo = '#login_email'; 
						break;
						
						case 2: 
						default:
							var campo = '#login_senha'; 
						break;
					}
					alerta(mensagem_retorno);
					
					$("#dialog_alerta").dialog({
						close: function(event, ui) {
							$(campo).focus();
							// mantém destacado por 3 segundos
							$(campo).addClass('campo_obr_foco');
							window.setTimeout(function() {$(campo).removeClass('campo_obr_foco');}, 3000);
						}
					});
				}
			}});
		}
		return false;
	}
}



function submete_reenvio() { //alert('submete_reenvio');
	show_loading('#bt_submete_login');
	
	var formulario = document.getElementById('form_login');
	
	if(!checar(formulario)) {
		hide_loading();
	} else {
		var email = $('#login_email').val(); //alert(id_condominio);
		
		var parametros  = "metodo=submete_reenvio";
			parametros += "&email=" + email;

		$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
			
			if(erro==0) { 
				alerta(mensagem_retorno);
				toggle_login();
			} else {
				var campo = '#email_esqueci';
				alerta(mensagem_retorno);
				// mostra o campo que deve ser preenchido
				$(campo).addClass('campo_obr_foco');
				campo_focado = campo;
			}
			hide_loading();
		}});	
	}
	return false;
}


function toggle_login() {
	var campo_link = '#bt_toggle_login';
	// troca as frases do link "Esqueceu sua senha?"
	var prox_valor = $(campo_link).text();
	$(campo_link).text($(campo_link).attr('rel'));
	$(campo_link).attr('rel', prox_valor);
	
	// troca as visibilidades
	var campo_senha = '#login_senha';
	var label_senha = $('label[for=' + $(campo_senha).attr('id') + ']');
	var botao_submit = '#bt_submete_login';
	$(label_senha).toggle();
	$(campo_senha).toggle();
	$(botao_submit + ' span').toggleClass('ui-icon-key');
	$(botao_submit + ' span').toggleClass('ui-icon-disk');
	$('#login_senha').toggleClass('obr');
	$('#login_email').focus();

	// troca o label do botão submit
	var prox_valor = $(botao_submit + ' strong').text();
	$(botao_submit + ' strong').text($(botao_submit).attr('rel'));
	$(botao_submit).attr('rel', prox_valor);

	// troca a variável que define a ação do submit
	// 1=login / 2=reenvio
	var valor = $('#enviar').val()==1 ? 2 : 1;
	$('#enviar').val(valor);
}




var elemento_oculto_loading=null;
function show_loading(sel_elemento, opt_zindex) {
	// 'sel_elemento' é o seletor do objeto que será ocultado enquanto o loading aparece
	elemento_oculto_loading = sel_elemento;

	var elemento = $(sel_elemento); //alert($(elemento).attr('id'));


	if(opt_zindex != undefined) {
		// muda o z-index	
		$('#loading').css('z-index', opt_zindex);
	}

	var posicao = elemento.offset(); 
	var x_elemento = parseInt(posicao.left); 
	var y_elemento = parseInt(posicao.top);
	var w_elemento = elemento.width();
	var h_elemento = elemento.height();
	//alert('(' + x_elemento + ', ' + y_elemento + ')\n' + w_elemento + 'x' + h_elemento);
	
	var w_loading = parseInt($('#loading').css('width'));
	var h_loading = parseInt($('#loading').css('height'));
	var x_loading = Math.floor(x_elemento + ((w_elemento-w_loading)/2));
	var y_loading = Math.floor(y_elemento + ((h_elemento-h_loading)/2));
	
	
	$('#loading').css('left', x_loading + 'px');
	$('#loading').css('top', y_loading + 'px');
	$('#loading').show();
	elemento.css('visibility', 'hidden');
}


function hide_loading() {
	$('#loading').hide();
	$('#loading').css('z-index', 1000); // retorna o z-index para o normal (acima de tudo, menos dos pop-ups)
	if(elemento_oculto_loading!=null) {
		$(elemento_oculto_loading).css('visibility', 'visible');
		elemento_oculto_loading=null;
	}
}






//_________________________________________________________



// módulo usuários força a seleção de todos os demais
// (para evidenciar sua importância e consequência)
$('.perm').live('click', function(){
	if($(this).attr('id')=='perm_1') {
		if($(this).is(':checked')) {
			$('.perm').attr('checked', true);
		}
	} else {
		if($(this).not(':checked')) {
			$('#perm_1').attr('checked', false);
		}
	}
});

//___*/


function alterna(seletor) {
	$(seletor).slideToggle();
	return false;
}





function checar_novo(formulario)
{
	var highlight = false;
	var erro = false;
	var msg; // mensagem de erro
	
	for(var i=0;i<formulario.elements.length;i++)
	{
		var campo = formulario.elements[i];
		
		
		if(campo.type=="text" || campo.type=="hidden" || campo.type=="select" || campo.type=="select-one" || campo.type=="password" || campo.type=="file" || campo.type=="textarea" || campo.type=="radio")
		{
			var obriga = $(campo).hasClass('obr');
			var rotulo = $('label[for=' + $(campo).attr('id') + '] span').text();
			
			if(campo.type=="radio" && obriga)
			{
				var meuradio=document.getElementsByName(campo.getAttribute('name'));
				var preencheu = false;
				for (var k=0; k<meuradio.length; k++) 
				{
					if (meuradio[k].checked)
					{
						preencheu = true;
					}
				}
				if (preencheu==false)
				{
					//alert("Ao menos uma das opções do campo '" + rotulo + "' deve ser selecionada.");
					erro = true;
					msg = "Ao menos uma das opções do campo <strong>" + rotulo + "</strong> deve ser selecionada.";
					//return false;
					//break;
				}
			}
			else if(obriga && trim(campo.value)=="")
			{
				//alert("O campo '" + rotulo + "' não pode ficar vazio.");
				erro = true;
				msg = "O campo <strong>" + rotulo + "</strong> não pode ficar vazio.";
				highlight = true;
			}
			else if($(campo).hasClass('v_email'))
			{
				// valida campos de e-mail
				if(!confere_email($(campo).val()))
				{
					//alert("E-mail inválido.");
					erro = true;
					msg = "E-mail inválido.";
					highlight = true;
				}
			}
			
			
			if(erro)
			{
				//alert(msg);
				alerta(msg);
				
				if(highlight)
				{
					// quando fechar o alerta, foca no campo e destaca
					$("#dialog_alerta").dialog({
						close: function(event, ui) {
							$(campo).focus();
							// mantém destacado por 3 segundos
							$(campo).addClass('campo_obr_foco');
							window.setTimeout(function() {$(campo).removeClass('campo_obr_foco');}, 3000);
						}
					});
				}
				
				return false;
				break;
			}
		}
	}
	return true;
}









function exclui_foto_usuario(id_usuario) { //alert('submete_reenvio');
	var campo = '#container_foto_del';
	show_loading(campo + ' a.ico_del_ajax');
	
	var parametros  = "metodo=exclui_foto_usuario";
		parametros += "&id_usuario=" + id_usuario;
	
	if(window.confirm('Você tem certeza de que deseja excluir este item?')) {
		$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
			
			if(erro!=0) { 
				alerta(mensagem_retorno);
			} else {
				$(campo).html(mensagem_retorno);
			}
		}});	
	}
	hide_loading();
	return false;
}






function MM_mask(e,src,mask) {
	if(window.event) { 
		_TXT = e.keyCode; 
	} else if(e.which) { 
		_TXT = e.which; 
	}
	
	if(_TXT > 47 && _TXT < 58) { 
		var i = src.value.length; 
		var saida = mask.substring(0,1); 
		var texto = mask.substring(i);
		if (texto.substring(0,1) != saida) { 
			src.value += texto.substring(0,1); 
		} 
		return true; 
	} else { 
		if (_TXT != 8) { 
			return false; 
		} else { 
			return true; 
		}
	}
}



function lista_cidades(campo_estado, id_cidade_sel)
{
	var estado = $(campo_estado).val(); //alert('estado: ' + estado);
	
	show_loading($('#combo_cidade'));

	var parametros  = "metodo=lista_cidades";
		parametros += "&estado=" + estado;
		parametros += "&id_cidade_sel=" + id_cidade_sel;
	
	$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
		var dados=eval(limpa_retorno_ajax(retorno));
		var erro=dados[0];
		var mensagem_retorno=dados[1];
		
		if(erro==0) { //alert(mensagem_retorno);
			$('#combo_cidade').html(mensagem_retorno);//mensagem_retorno);
			hide_loading();
		} else {
			alert(mensagem_retorno);
		}
	}});	
	return false;
	
}



//__________________________________________________________________

function toggle_exibir(classe, id_registro, elemento) {
	//alert('elemento: ' + $(elemento).attr('title'));
	show_loading($(elemento));
	var urlAjax = $(elemento).attr('href');
	var parametros  = "method=changeStatus";
		parametros += "&classe=" + classe;
		parametros += "&id_registro=" + id_registro;
	
	$.ajax({type:"GET", datatype:'json', url:urlAjax, data:parametros, success:function(retorno) {
		var dados=eval(limpa_retorno_ajax(retorno));
		var erro=dados[0];
		var mensagem_retorno=dados[1];
		
		if(erro==0) {
			$(elemento).toggleClass('ico_olho_on_on ico_olho_off_on');
			hide_loading();
		} else {
			alert(mensagem_retorno);
		}
	}});	
	return false;
}
//__________________________________________________________________

function toggle_destaque(classe, id_registro, elemento) {
	//alert('elemento: ' + $(elemento).attr('title'));
	show_loading($(elemento));

	var parametros  = "metodo=toggle_destaque";
		parametros += "&classe=" + classe;
		parametros += "&id_registro=" + id_registro;
	
	$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
		var dados=eval(limpa_retorno_ajax(retorno));
		var erro=dados[0];
		var mensagem_retorno=dados[1];
		
		if(erro==0) {
			$(elemento).toggleClass('ico_destaque_on_on ico_destaque_off_on');
			hide_loading();
		} else {
			alert(mensagem_retorno);
		}
	}});	
	return false;
}
//__________________________________________________________________

function fast_insert(classe, id_select, elemento) {
	var nome = window.prompt('Digite o nome do item');
	if(nome!=null) {
		show_loading($(elemento));
	
		var parametros  = "metodo=fast_insert";
			parametros += "&classe=" + classe;
			parametros += "&id_select=" + id_select;
			parametros += "&nome=" + nome;
		
		$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro = dados[0];
			var mensagem_retorno = dados[1];
			
			if(erro==0) {
				// adiciona o elemento no select
				$('#' + id_select).append(new Option(nome, mensagem_retorno, true, true));
				hide_loading();
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
	return false;
}

//__________________________________________________________________


function toggle_cartao_coop() {
	var campo_check = $('#bool_cartao');
	
	if($(campo_check).is(':checked')) {
		$('#preco_cartao, #preco_parc_1, #preco_parc_2, #preco_total').attr('disabled', false);
	} else {
		$('#preco_cartao, #preco_parc_1, #preco_parc_2, #preco_total').val('');
		$('#preco_cartao, #preco_parc_1, #preco_parc_2, #preco_total').attr('disabled', true);
	}
	
}


//__________________________________________________________________




function limita_texto(campo, limite) {
	var limite = limite ? limite : $(campo).attr('maxlength');
	var contador = $('label[for=' + $(campo).attr('id') + '] span.contador');
	var tamanho = $(campo).val().length;
	var numero = limite - tamanho;
	
	if (numero<=0) { // se for maior que o limite, corta
		$(campo).val($(campo).val().substring(0, limite));
		$(contador).addClass('contador_full');
		$(campo).addClass('campo_obr_foco');
		window.setTimeout(function() {
			$(contador).removeClass('contador_full');
			$(campo).removeClass('campo_obr_foco');
		}, 2000);
		numero = 0;
	}
	$(contador).text(numero);
}



//__________________________________________________________________


function toggle_nova_relacao() { 
	$('#caixa_relacao').slideToggle();
}


function excluir_relacao_oferta(id_relacao) {
	if(window.confirm('Excluir esta relação?')) {
		show_loading('#row_rel_' + id_relacao + ' .ico_cancel_on');

		var parametros = "metodo=excluir_relacao_oferta";
			parametros+= "&id_relacao=" + id_relacao;

		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading(true);
				$('#row_rel_' + id_relacao).fadeOut(function() {
					// conta quantas linhas restaram na tabela
					$('#row_rel_' + id_relacao).remove();
					var num_linhas = $('#tb_relacoes_ofertas tr').length;
					if(num_linhas<=1) {
						$('#tb_relacoes_ofertas tr').fadeOut();
					}
				});
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}




function define_revista(id_revista) {
	if(window.confirm('Você tem certeza de que quer tornar esta revista visível no site?')) {
		location.href='define_revista.php?id=' + id_revista;
	}
}


function find_lat_long() {
	$('#latitude').val('Buscando...');
	$('#longitude').val('Buscando...');
			
	var cidade = $('#id_cidade option:selected').text();
	var estado = $('#estado option:selected').text();
	var endereco = $('#endereco').val() + ', ' + cidade + ', ' + estado + ', ' + $('#cep').val(); 
	//alert('endereco: ' + endereco);
	var geocoder = new google.maps.Geocoder();

	geocoder.geocode( { 'address': endereco}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			console.log(results[0].geometry);
			var lat = results[0].geometry.location.ab;
			var long = results[0].geometry.location.cb;
			$('#latitude').val(lat);
			$('#longitude').val(long);
		} else {
			$('#latitude').val('');
			$('#longitude').val('');
			alert('Endereço não encontrado. Erro: ' + status);
		}
	});
	
}




function get_tecla(e){
	if (window.event)
		return window.event.keyCode;
	else if (e)
		return e.which;
	else
		return null;
}

function keyRestrict(e, validchars) {
	var key='', keychar='';
	key = get_tecla(e);
	if (key == null) 
		return true;
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	validchars = validchars.toLowerCase();
	if (validchars.indexOf(keychar) != -1)
		return true;
	if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
		return true;
		
	return false;
}
