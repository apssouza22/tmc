<?php

/**
 * Cuida das unidades do cleinte
 *
 * @author apssouza
 */
class ClienteUnidade extends Model
{
	const TB_NAME = 'unidade';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'listar.php';
	const PG_EDITAR = 'form.php';
	const PG_PASTA = 'cliente';
	
	public function getCliente(){
		return new Cliente($this->cliente_id);
	}
	
	public function getAllAtivos(){
		$filter = new Filter;
		$filter->where('status = 1');
		return $this->getAll($filter);
	}
	
	
}

?>
