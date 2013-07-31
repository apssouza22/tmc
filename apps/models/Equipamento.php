<?php

/**
 * Cuida dos equipamentos do sistema
 *
 * @author apssouza
 */
class Equipamento extends Model
{
	const TB_NAME = 'equipamento';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'listar.php';
	const PG_EDITAR = 'form.php';
	const PG_PASTA = 'equipamento';
	
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
