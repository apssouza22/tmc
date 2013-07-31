<!--
// funções de Javascript

$(document).ready(init);

function init() { //inicializa todas as ações necessárias no load da página
	if(document.getElementById('menusup')) {
		DynarchMenu.setup('menusup', {electric: true});
	}
	
	// CEE-box
	$(".ceebox").ceebox();
	
	$('.bt_ico_off').click(function(event) {
		event.preventDefault();
	});
	
	
}


var endereco_padrao_ajax = DIR_CMS_HTM_ROOT + "/ajax.php";


//_____________________________________________


function trim(inputString) {
   // Removes leading and trailing spaces from the passed string. Also removes
   // consecutive spaces and replaces it with one space. If something besides
   // a string is passed in (null, custom object, etc.) then return the input.
   if (typeof inputString != "string") { return inputString; }
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






function checar(formulario)
{
	for(var i=0;i<formulario.elements.length;i++)
	{
		var campo=formulario.elements[i];
		
		if(campo.type=="text" || campo.type=="hidden" || campo.type=="select" || campo.type=="select-one" || campo.type=="password" || campo.type=="file" || campo.type=="textarea" || campo.type=="radio")
		{
			var obriga=campo.getAttribute('obrigatorio');
			var nomecampoatual=campo.getAttribute('nomecampo');
			
			if(campo.type=="radio" && obriga==1)
			{
				var meuradio=document.getElementsByName(campo.getAttribute('name'));
				var preencheu = false;
				for (var k=0; k<meuradio.length; k++) 
				{
					//alert(k + "- teste: " + meuradio[k].value + " está " + meuradio[k].checked);
					if (meuradio[k].checked)
					{
						preencheu = true;
					}
				}
				if (preencheu==false)
				{
					alert("Ao menos uma das opções do campo '" + nomecampoatual + "' deve ser selecionada.");
					return false;
					break;
				}
			}
			else if(obriga==1 && trim(campo.value)=="")
			{
				alert("O campo '" + nomecampoatual + "' não pode ficar vazio.");
				// mostra o campo que deve ser preenchido
				$('#' + campo.id).addClass('campo_obr_foco');
				window.setTimeout(function() {$('#' + campo.id).removeClass('campo_obr_foco');}, 3000);
				campo.focus();
				return false;
				break;
			}
				
		}
	}
	return true;
}



function limita_texto(field, countfield, maxlimit) 
     {
	 if (field.value.length > maxlimit) // if too long...trim it!
	      {
		  field.value = field.value.substring(0, maxlimit);
		  }
     else 
	      {
		  countfield.innerHTML = maxlimit - field.value.length;
		  }
     }




function validarmaximo(valor, maximo)
     {
	 if(valor>maximo)
	      {
		  window.alert("O valor máximo para este campo é " + maximo);
		  return true;
		  }
	 else
	      {
		  return false;
		  }
	 }


function validarnumero(e) {
	var tecla = codigo_tecla(e);
	var valor=String.fromCharCode(tecla); //alert('tecla: '+tecla + ', valor: '+valor )
	if(isNaN(valor) && !((tecla>=37 && tecla<=40) || tecla==8 || tecla==9 || tecla==13 || (tecla==46 && valor!='.'))) {
		cancela_evento(e);
	}
}

function codigo_tecla(e) { //alert('codigo_tecla');
	return e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
}

function cancela_evento(e) { //alert('cancelou');
	if(e.keyCode) e.returnValue=false; else e.preventDefault();
}



function validardecimal()
{
var tecla=window.event.keyCode;
var valor=String.fromCharCode(tecla);

if (parseInt(valor)!=valor && valor!="-" && valor!="." && event.keyCode!="13")
	{
	event.returnValue=false;
	}
}



function validardecimalbr()
{
var tecla=window.event.keyCode;
var valor=String.fromCharCode(tecla);

if (parseInt(valor)!=valor && valor!="-" && valor!="," && event.keyCode!="13")
	{
	event.returnValue=false;
	}
}



function confirma(destino, mensagem)
	{
	if(window.confirm(mensagem))
		{
		window.location.href=destino;
		}
	}











//_______FOLHINHA_________________

function fecha_folhinha()
     {
	 var removame=document.getElementById("divfolhinha");
	 if(removame!=null)
	      {
	 	  removame.parentNode.removeChild(removame);
		  }
	 }




function abre_folhinha(id_clicado, id_formulario, id_campo_dia, id_campo_mes, id_campo_ano)
     {
	 var campo_dia=document.getElementById(id_campo_dia);
	 var campo_mes=document.getElementById(id_campo_mes);
	 var campo_ano=document.getElementById(id_campo_ano);

	 
	 var dia_sel=campo_dia.value;
	 var mes_sel=campo_mes.options[campo_mes.selectedIndex].value;
	 var ano_sel=campo_ano.value;
	 
	 
	 //removendo outra instância do objeto que exista
	 var divfolhinha=document.getElementById("divfolhinha");

	 if (divfolhinha!=null)
	      {
		  if(id_clicado==divfolhinha.origem)
		       {
			   //alert("já existe e é o mesmo: " + id_clicado + " e " + divfolhinha.origem);
			   var pode_criar=false;
			   }
		  else
		       {
			   //alert("já existe mas não é o mesmo: " + id_clicado + " e " + divfolhinha.origem);
			   var pode_criar=true;
			   }
          fecha_folhinha();
		  }
     else
	      {
		  var pode_criar=true;
		  }



     if(pode_criar)
	      {
	 	  var novodiv=document.createElement("div");
	 	  novodiv.id="divfolhinha";
	 	  document.body.appendChild(novodiv);
		  //divfolhinha==document.getElementById("divfolhinha");
	 


		// Get the scroll offset of the window.
		var yScroll;
		if (self.pageYOffset) // all except Explorer
		{
			yScroll = self.pageYOffset;
		}
		else if (document.documentElement && document.documentElement.scrollTop) // Explorer 6 Strict
		{
			yScroll = document.documentElement.scrollTop;
		}
		else if (document.body) // all other Explorers
		{
			yScroll = document.body.scrollTop;
		}


		  //var imagemid=window.event.srcElement.id;
		  var imagemclicada=document.getElementById(id_clicado);
		  var imagemy=findPosY(imagemclicada);
		  var imagemx=findPosX(imagemclicada);
		  //alert("imagem clicada: " + imagemid);

	 	  var largura_div=150;
	 	  var altura_div=135;
	 
	 	  var coordenadax=imagemx-0-largura_div;
	 	  var coordenaday=imagemy+20;
		  

		  //alert("ponto: " + pontoy + ", coordy: " + coordenaday);
		  //alert("ponto: " + pontox + ", coordx: " + coordenadax);
	 
	 	  novodiv.style.position="absolute";
	 	  novodiv.style.display="block";
	 	  novodiv.style.left=coordenadax + "px";
	 	  novodiv.style.top=coordenaday + "px";
	 	  novodiv.style.width=largura_div + "px";
	 	  novodiv.style.height=altura_div + "px";
	 	  novodiv.style.border="1px solid #666";
	 	  novodiv.style.background="#eee";
	 	  novodiv.origem=id_clicado;
	 	  novodiv.innerHTML='<iframe src="../ferramentas/folhinha.php?dia=' + dia_sel + '&mes=' + mes_sel + '&ano=' + ano_sel + '&id_campo_dia=' + id_campo_dia + '&id_campo_mes=' + id_campo_mes + '&id_campo_ano=' + id_campo_ano + '" frameborder="0" scrolling="no" width="150" height="135"></iframe>';
		  }
	 
	 
	 
	 //alert("selecionado atualmente: " + forms[0].dia.value + "/" forms[0].mes.value + "/" + forms[0].ano.value);
	 } 





function hide_and_seek(id_item) {
	$(id_item).slideToggle();
}





function checkAll(theForm, cName) {
	for (i=0,n=theForm.elements.length;i<n;i++)
	if (theForm.elements[i].className.indexOf(cName) !=-1)
	if (theForm.elements[i].checked == true) {
	theForm.elements[i].checked = false;
	} else {
	theForm.elements[i].checked = true;
	}
}



function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}





function getIndex(elemento, valor) 
	{
	result = -1;
	index = 0;
	while(index < elemento.length && result==-1)
		if(elemento[index].value == valor)
			result = index;
		else
			index++;
	return result;
	}




function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}		



var elemento_oculto_loading=null;
function show_loading(sel_elemento, opt_zindex) {
	// 'sel_elemento' é o seletor do objeto que será ocultado enquanto o loading aparece
	elemento_oculto_loading = sel_elemento;

	var elemento = $(sel_elemento);


	if(opt_zindex != undefined) {
		// muda o z-index	
		$('#loading').css('z-index', opt_zindex);
	}
	var posicao = elemento.offset(); 
	var x_elemento = parseInt(posicao.left); 
	var y_elemento = parseInt(posicao.top);
	var w_elemento = elemento.width();
	var h_elemento = elemento.height();
	
	var w_loading = 18;
	var h_loading = 18;
	var x_loading = Math.floor(x_elemento + (w_elemento-w_loading)/2);
	var y_loading = Math.floor(y_elemento + (h_elemento-h_loading)/2);
	
	//alert('(' + x_elemento + ', ' + y_elemento + ')\n' + w_elemento + 'x' + h_elemento + '\n\n(' + x_loading + ', ' + y_loading + ')\n' + w_loading + 'x' + h_loading);
	
	$('#loading').css('left', x_loading);
	$('#loading').css('top', y_loading);
	$('#loading').show();
	elemento.hide();
}

function hide_loading(dont_show) {
	$('#loading').hide();
	$('#loading').css('z-index', 1000); // retorna o z-index para o normal (acima de tudo, menos dos pop-ups)
	if(elemento_oculto_loading!=null && !dont_show) {
		$(elemento_oculto_loading).show();
	}
	elemento_oculto_loading=null;
}




function limpa_retorno_ajax(retorno) {
	retorno=retorno.replace(/\+/g," ");
	return unescape(retorno);
}






function excluir_pdf_bike_ficha(id_ficha) {//alert('excluir_ficha: ' + id_ficha);
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_ficha';
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_pdf_bike_ficha";
			parametros+= "&id_ficha=" + id_ficha;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}



function excluir_pdf_fit_ficha(id_ficha) {//alert('excluir_ficha: ' + id_ficha);
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_ficha';
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_pdf_fit_ficha";
			parametros+= "&id_ficha=" + id_ficha;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}



function excluir_arquivo_bike(id_bike, campo) {
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_' + campo;
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_arquivo_bike";
			parametros+= "&id_bike=" + id_bike;
			parametros+= "&campo=" + campo;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}


function excluir_arquivo_fit(id_fit, campo) {
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_' + campo;
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_arquivo_fit";
			parametros+= "&id_fit=" + id_fit;
			parametros+= "&campo=" + campo;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}



function excluir_arquivo_loja(id_loja, campo) {
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_' + campo;
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_arquivo_loja";
			parametros+= "&id_loja=" + id_loja;
			parametros+= "&campo=" + campo;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}




function excluir_arquivo_noticia(id_noticia, campo) {
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_' + campo;
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_arquivo_noticia";
			parametros+= "&id_noticia=" + id_noticia;
			parametros+= "&campo=" + campo;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}


function excluir_arquivo_grupo(id_grupo, campo) { 
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_' + campo;
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_arquivo_grupo";
			parametros+= "&id_grupo=" + id_grupo;
			parametros+= "&campo=" + campo;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}


function excluir_arquivo_orkut(id_orkut, campo) { 
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_' + campo;
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_arquivo_orkut";
			parametros+= "&id_orkut=" + id_orkut;
			parametros+= "&campo=" + campo;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}




function excluir_quadro(id_quadro) {
	if(window.confirm('Você tem certeza de que quer excluir DEFINITIVAMENTE este quadro?')) {
		show_loading('#row_quadro_' + id_quadro + ' .ico_del_on');

		var parametros = "metodo=excluir_quadro";
			parametros+= "&id_quadro=" + id_quadro;

		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading(true);
				$('#row_quadro_' + id_quadro).fadeOut();
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}



function excluir_cor(id_cor) {
	if(window.confirm('Excluir esta cor?')) {
		show_loading('#bloco_cor_' + id_cor);
		$('#x_cor_' + id_cor).hide();

		var parametros = "metodo=excluir_cor";
			parametros+= "&id_cor=" + id_cor;

		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading(true);
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}



function excluir_relacao_imovel(id_relacao) {
	if(window.confirm('Excluir esta relação?')) {
		show_loading('#row_rel_' + id_relacao + ' .ico_del_on');

		var parametros = "metodo=excluir_relacao_imovel";
			parametros+= "&id_relacao=" + id_relacao;

		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading(true);
				$('#row_rel_' + id_relacao).fadeOut(function() {
					$('#p_inserir_relacao').show();
				});
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}


function excluir_relacao_fit(id_relacao) {
	if(window.confirm('Excluir esta relação?')) {
		show_loading('#row_rel_' + id_relacao + ' .ico_del_on');

		var parametros = "metodo=excluir_relacao_fit";
			parametros+= "&id_relacao=" + id_relacao;

		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading(true);
				$('#row_rel_' + id_relacao).fadeOut(function() {
					$('#p_inserir_relacao').show();
				});
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}


function excluir_material_lojista(id_material, url_back) {
	if(window.confirm('Excluir esta foto?')) {
		location.href = "excluir_material_lojista.php?id_material=" + id_material + "&back=" + url_back;
	}
}


function toggle_nova_relacao() { 
	$('#caixa_relacao').slideToggle();
}

function toggle_loja_fisica() {
	$('#caixa_loja_fisica').slideToggle();
	
	var obr_fisica = $('#bool_fisica').is(':checked') ? 1 : 0;
	$('#endereco').attr('obrigatorio', obr_fisica);
	$('#numero').attr('obrigatorio', obr_fisica);
	$('#bairro').attr('obrigatorio', obr_fisica);
	$('#cidade').attr('obrigatorio', obr_fisica);
	$('#estado').attr('obrigatorio', obr_fisica);
	
}

function toggle_loja_online() {
	$('#caixa_loja_online').slideToggle();

	var obr_online = $('#bool_online').is(':checked') ? 1 : 0;
	$('#url').attr('obrigatorio', obr_online);
}





function excluir_bike_detalhe(id_detalhe) {
	if(window.confirm('Excluir este detalhe?')) {
		show_loading('#detalhe_' + id_detalhe + ' .ico_del_on');

		var parametros = "metodo=excluir_bike_detalhe";
			parametros+= "&id_detalhe=" + id_detalhe;

		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$('#detalhe_' + id_detalhe).fadeOut();
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}


function excluir_fit_detalhe(id_detalhe) {
	if(window.confirm('Excluir este detalhe?')) {
		show_loading('#detalhe_' + id_detalhe + ' .ico_del_on');

		var parametros = "metodo=excluir_fit_detalhe";
			parametros+= "&id_detalhe=" + id_detalhe;

		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$('#detalhe_' + id_detalhe).fadeOut();
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}


function toggle_exibir(classe, id_registro, elemento) {
	//alert('elemento: ' + $(elemento).attr('title'));
	show_loading($(elemento));

	var parametros  = "metodo=toggle_exibir";
		parametros += "&classe=" + classe;
		parametros += "&id_registro=" + id_registro;
	
	$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
		var dados=eval(limpa_retorno_ajax(retorno));
		var erro=dados[0];
		var mensagem_retorno=dados[1];
		
		if(erro==0) {
			$(elemento).toggleClass('ico_olho_on ico_olho_off');
			hide_loading();
		} else {
			alert(mensagem_retorno);
		}
	}});	
	return false;
}




function define_produto() {
	if($('#tipo_produto_1').is(':checked')) {
		$('#field_bike').show(); $('#id_bike').attr('obrigatorio',1);
		$('#field_fit').hide(); $('#id_fit').attr('obrigatorio',0);
		
	} else {
		$('#field_bike').hide(); $('#id_bike').attr('obrigatorio',0);
		$('#field_fit').show(); $('#id_fit').attr('obrigatorio',1);
	}
}


function lista_cidades(campo_estado, id_cidade_sel)
{
	estado = $(campo_estado).val(); //alert('estado: ' + estado);
	
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

function lista_cidades_onde(campo_estado, tipo_produto, id_tipo, tipo_consulta)
{
	estado = $(campo_estado).val(); //alert('estado: ' + estado);
	
	show_loading($('#combo_cidade'));

	var parametros  = "metodo=lista_cidades_onde";
		parametros += "&estado=" + estado;
		parametros += "&tipo_produto=" + tipo_produto;
		parametros += "&id_tipo=" + id_tipo;
		parametros += "&tipo_consulta=" + tipo_consulta;
		
	
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





function lista_torres(campo_condominio, id_torre_sel)
{
	id_condominio = $(campo_condominio).val(); //alert('condominio: ' + condominio);
	
	show_loading($('#combo_torre'));

	var parametros  = "metodo=lista_torres";
		parametros += "&id_condominio=" + id_condominio;
		parametros += "&id_torre_sel=" + id_torre_sel;
	
	$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
		var dados=eval(limpa_retorno_ajax(retorno));
		var erro=dados[0];
		var mensagem_retorno=dados[1];
		
		if(erro==0) { //alert(mensagem_retorno);
			$('#combo_torre').html(mensagem_retorno);//mensagem_retorno);
			hide_loading();
		} else {
			alert(mensagem_retorno);
		}
	}});	
	return false;
	
}



function inserir_torre(id_condominio)
{
	if(nome = window.prompt('Nome da torre:'))
	{
		//alert('nome: ' + nome);
		show_loading($('#link_torre'));
	
		var parametros  = "metodo=inserir_torre";
			parametros += "&id_condominio=" + id_condominio;
			parametros += "&nome=" + nome;
		
		$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
			
			if(erro==0) { //alert(mensagem_retorno);
				location.reload(true);
			} else {
				alert(mensagem_retorno);
			}
		}});	
		return false;
		
	}
}


function editar_torre(id_torre, nome_atual, id_condominio)
{
	if(nome = window.prompt('Nome da torre:', nome_atual))
	{
		//alert('nome: ' + nome);
		show_loading($('#td_edit_torre_' + id_torre));
	
		var parametros  = "metodo=editar_torre";
			parametros += "&id_torre=" + id_torre;
			parametros += "&nome=" + nome;
		
		$.ajax({type:"GET", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
			
			if(erro==0) { //alert(mensagem_retorno);
				location.reload(true);
			} else {
				alert(mensagem_retorno);
			}
		}});	
		return false;
		
	}
}



function excluir_regulamento(id_condominio) {
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_regulamento';
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_regulamento";
			parametros+= "&id_condominio=" + id_condominio;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}



function excluir_convencao(id_condominio) {
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#ctrl_convencao';
		show_loading(id_controle + ' .bt_ico');
		
		var parametros = "metodo=excluir_convencao";
			parametros+= "&id_condominio=" + id_condominio;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_controle).html('<em>' + mensagem_retorno + '</em>');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}




function excluir_boleto_import(arquivo, cont, var_valido) {
	if(window.confirm('Você tem certeza de que deseja excluir DEFINITIVAMENTE este arquivo?')) {
		var id_controle = '#lixeira_' + cont;
		var id_row = '#row_' + cont; //alert(id_controle + ', ' + id_row); return false;
		show_loading(id_controle);
		
		var parametros = "metodo=excluir_boleto_import";
			parametros+= "&arquivo=" + arquivo;
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				hide_loading();
				$(id_row).fadeOut();
				atualiza_validos(var_valido);
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
}

function atualiza_validos(var_valido) {
	var qtd_validos = var_valido==1 ? parseInt($('#qtd_validos').text())-1 : parseInt($('#qtd_validos').text());
	var qtd_total = parseInt($('#qtd_total').text())-1;
	var pct_total = qtd_total==0 ? 0 : Math.floor(qtd_validos/qtd_total*100);

	$('#pct_total').text(pct_total + '%');
	$('#qtd_validos').text(qtd_validos);
	$('#qtd_total').text(qtd_total);
	
	if(qtd_validos==0) {
		$('#bt_iniciar_importacao').fadeOut();
	}
	
	if(qtd_total==0) {
		$('#bt_excluir_importacao').fadeOut();
	}
}



function toggle_slide(seletor) {
	$(seletor).slideToggle();
}






-->