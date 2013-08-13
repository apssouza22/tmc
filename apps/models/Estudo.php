<?php


/**
 * Cuida dos cadastros de estudos de viabilidade
 *
 * @author apssouza
 */
class Estudo extends Model
{
	const TB_NAME = 'estudo';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'detalhes.php';
	const PG_EDITAR = 'form.php';
	const PG_PASTA = 'estudo';
	
	
	
	public function getChamado(){
		return new Chamado($this->chamado_id);
	}
	
}

?>
