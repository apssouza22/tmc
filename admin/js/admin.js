(function() {

	cliente();


	function cliente() {
		$('.js-addNovaUnidade').live('click', function() {
			$novo = $('.modelo').clone()
					.removeClass('modelo')
					.show();
			$novo.find('.matriz').attr('name', 'matriz_' + totalUnidades++);
			$('#form_ins').append($novo);
		});
	}



	function l(el) {
		console.log(el);
	}
})();

function exportarRelatorioIndisponibilidade() {
	$('#form_ins').attr('action', 'indisponibilidadeExport.php').submit();
}


function getUnidadesByCliente(self) {
	var cliente = $(self).val();
	if (cliente != '') {
		ajax({
				idCliente: cliente,
				classe: 'Cliente',
				method: 'getUnidadesHtml'
			}, function(r) {
				$('#unidade').html(r)
			});
	}
}

function deletarUnidade(self){
	
	if(window.confirm('Deseja realmente deletar esta unidade')){
		var idUnidade = $(self).data('id');
		ajax({
				id: idUnidade,
				classe: 'ClienteUnidade',
				method: 'delete2'
			}, function(){
				$(self).parents('.unidade').remove();
				$(self).parents('.caixa').remove();
			});
	}
}

function ajax(postData, callback){
	$.ajax({type: "POST",
			url: '../../ajax.php',
			data: postData,
			success: callback
		});
}