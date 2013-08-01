(function(){
	
	cliente();
	
	
	function cliente(){
		$('.js-addNovaUnidade').live('click',function(){
			$novo = $('.modelo').clone()
					.removeClass('modelo')
					.show();
			$('#form_ins').append($novo);
		});
	}
	
	function l(el){
		console.log(el);
	}
})();

