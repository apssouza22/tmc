// JavaScript Document

// vetores de filtros de tipo de arquivo
var vetor_ff_zip = new Array({description:"Arquivos ZIP", extensions:"*.zip"});
var vetor_ff_img = new Array({description:"Imagens", extensions:"*.jpg;*.jpeg;*.png;*.gif"});
var vetor_ff_img_png = new Array({description:"Imagens", extensions:"*.png"});
var vetor_ff_img_gif = new Array({description:"Imagens", extensions:"*.gif"});
var vetor_ff_img_jpg = new Array({description:"Imagens", extensions:"*.jpg;*.jpeg"});

var vetor_ff_vid = new Array({description:"Vídeos", extensions:"*.avi;*.mov;*.mpg"});
var vetor_ff_pdf = new Array({description:"Arquivos PDF", extensions:"*.pdf"});
var vetor_ff_doc = new Array({description:"Arquivos Word", extensions:"*.doc;*.docx"});
var vetor_ff_xls = new Array({description:"Planilhas", extensions:"*.xls;*.xlsx"});
var vetor_ff_ppt = new Array({description:"Apresentações", extensions:"*.ppt;*.pptx"});
var vetor_ff_swf = new Array({description:"Animações e filmes Flash", extensions:"*.swf;*.flv"});
var vetor_ff_txt = new Array({description:"Arquivos texto", extensions:"*.txt;*.csv"});



// classe FileUploader

function FileUploader (id_obj, seletor_campo, seletor_div, php_upload, vetor_filtro, max_file_size) { 
	this._id_objeto = id_obj;
	this._campo = seletor_campo;
	this._div = seletor_div;
	
	// Instantiate the uploader and write it to its placeholder div.
	//var uploader = new YAHOO.widget.Uploader("uploaderUI");
	var uploader = new YAHOO.widget.Uploader(this._id_objeto);
	this._uploader = uploader;
	
	uploader.addListener('contentReady', handleContentReady);
	uploader.addListener('fileSelect',onFileSelect)
	uploader.addListener('uploadStart',onUploadStart);
	uploader.addListener('uploadProgress',onUploadProgress);
	uploader.addListener('uploadCancel',onUploadCancel);
	uploader.addListener('uploadCompleteData',onUploadComplete);
	uploader.addListener('uploadError', onUploadError);
	
	function handleContentReady (event) { //alert('teste: ' + event); //alert('dump: ' + dump(event));
		uploader.setAllowLogging(true);
		uploader.setAllowMultipleFiles(false);
		
		if(vetor_filtro!=null) { // cria o vetor de filtros
			var ff = new Array();
			for(var i=0; i<vetor_filtro.length; i++) {
				var vet = eval('vetor_ff_' + vetor_filtro[i]);
				ff.push(vet[0]);
			}
			
			// filtra as extensões de arquivo
			uploader.setFileFilters(ff);
		}
		
	}
	
	
	var fileID;
	function onFileSelect(event) {
		var erro_tamanho=false;
		for (var item in event.fileList) {
			if(YAHOO.lang.hasOwnProperty(event.fileList, item)) {
				YAHOO.log(event.fileList[item].id);
				fileID = event.fileList[item].id;
			}
			if(max_file_size!=null) { // limita o tamanho do arquivo, em KBytes
				var tamanho = Math.floor(event.fileList[item].size/1024);
				if(tamanho>max_file_size) {
					var tamanho_fmt = tamanho > 1024 ? Math.floor(tamanho/1024) + 'MB' : tamanho + 'KB';
					var max_file_size_fmt = max_file_size > 1024 ? Math.floor(max_file_size/1024) + 'MB' : max_file_size + 'KB';
					alert('Arquivo muito grande: ('+ tamanho_fmt +')\n\nO limite para este arquivo é de ' + max_file_size_fmt);
					erro_tamanho = true;
				}
			}
		}
		
		if(!erro_tamanho) {
			$(seletor_div + ' .arq_anterior .ico_view_on').hide();
			uploader.disable(); desabilita();
			reseta_barra(); 
			$(seletor_div + ' .upload_nome_imagem').text(event.fileList[fileID].name);
			upload();
		}
	}
	
	
	function upload() {
		if (fileID != null) {
			uploader.upload(fileID, php_upload);
			fileID = null;
		}
	}
	

	function onUploadProgress(event) {
		largura = Math.round(170*(event["bytesLoaded"]/event["bytesTotal"]));
		//alert('largura: ' + largura);
		$(seletor_div + ' .upload_bg_barra').width(largura);//largura + 'px');
	}
	
	
	function onUploadComplete(event) { //alert('O arquivo ' + event.id + ' foi transferido com sucesso.');
		uploader.clearFileList();
		//uploader.enable();
		reseta_barra(); 
		$(seletor_div + ' .upload_progresso').hide(); 
		$(seletor_div + ' .upload_box_arquivo').show();
	
		var resultado = event.data;
		if(resultado==0) {
			alert('Erro no upload do arquivo. Tente novamente.');
		} else {
			$(seletor_campo).val(resultado);
			
			// recupera a URL do arquivo para a visualização
			var parametros = "metodo=upload_view";
				parametros+= "&id_arquivo=" + resultado;
			
			$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
				var dados=eval(limpa_retorno_ajax(retorno));
				var erro=dados[0];
				var mensagem_retorno=dados[1];
		
				if(erro==0) {
					$(seletor_div + ' .upload_box_arquivo .ico_view_on').attr('href', mensagem_retorno);
				} else {
					alert(mensagem_retorno);
				}
			}});	
		}
	}
	
	
	function onUploadStart(event) {	//alert(id_obj);
		//$('#' + id_obj).css('visibility', 'hidden');
		$(seletor_div + ' .upload_progresso').show();
	}
	
	function onUploadError(event) {
		alert('erro no upload: ' + event.data);
	}
	
	function onUploadCancel(event) {
		//alert('cancelou');
	}

	function reseta_barra() { //alert('reseta_barra');
		$(this._div + ' .upload_bg_barra').width(0);
		$(this._div + ' .upload_nome_imagem').text('');
	}
	
	function desabilita() { //alert('desabilita');
		$('#' + id_obj).css('background-position', '-26px -26px'); 
		$('#' + id_obj).css('width', '1px'); $('#' + id_obj).css('height', '1px');
	}

	function habilita() { //alert('habilita');
		$('#' + id_obj).css('background-position', 'center center'); 
		$('#' + id_obj).css('width', '26px'); $('#' + id_obj).css('height', '26px');
	}
	
} // --> end Class FileUploader()




FileUploader.prototype = { 

	// função que apaga o arquivo e o registro no banco 
	upload_delete: function () {
		var folder = '#' + this._id_objeto;
		var campo = this._campo;
		var div = this._div;
		var uploader = this._uploader;
		
		$(div + ' .upload_box_arquivo').hide();
		$(div + ' .upload_loading').show();

		var parametros = "metodo=upload_delete";
			parametros+= "&id_arquivo=" + $(campo).val();
		
		$.ajax({type:"POST", datatype:'json', url:endereco_padrao_ajax, data:parametros, success:function(retorno) {
			var dados=eval(limpa_retorno_ajax(retorno));
			var erro=dados[0];
			var mensagem_retorno=dados[1];
	
			if(erro==0) {
				uploader.enable();
				$(folder).css('background-position', 'center center'); 
				$(folder).css('width', '26px'); $(folder).css('height', '26px');
				$(div + ' .ico_folder_on').show();
				$(div + ' .upload_loading').hide();
				$(campo).val('');
			} else {
				alert(mensagem_retorno);
			}
		}});	
	}
	
	,	
	
	// função que cancela o upload durante seu progresso
	cancelUpload: function(event) {
		this._uploader.cancel();
		this._uploader.clearFileList();
		this._uploader.enable(); habilita();
		
		//reseta a barra__________
		$(this._div + ' .upload_bg_barra').width(0);
		$(this._div + ' .upload_nome_imagem').text('');
		//________________________

		$(this._div + ' .upload_progresso').hide(); 
		$(this._div + ' .ico_folder_on').show();
		$(this._div + ' .upload_loading').hide();
		//$('#' + this._id_objeto).css('visibility', 'visible');
		$(this._campo).val('');
	}
}


