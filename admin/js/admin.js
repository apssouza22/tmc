(function(){
	
	cliente();
	
	
	function cliente(){
		$('.js-addNovaUnidade').live('click',function(){
			$novo = $('.modelo').clone()
					.removeClass('modelo')
					.show();
			$novo.find('.matriz').attr('name','matriz_'+totalUnidades++);
			l($novo);
			$('#form_ins').append($novo);
		});
	}
	
	function l(el){
		console.log(el);
	}
})();

