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
	
	/**
	 * Traz a lista completa de equipamentos com suas relações
	 * */
	public function getLista(){
		$oSelect = new Select('cl.empresa, uc.nome, eq.*', __CLASS__);
		return $oSelect->from(Equipamento::TB_NAME.' eq')
						->innerJoin(ClienteUnidade::TB_NAME . " uc ON uc.id = eq.unidade_id  ")
						->innerJoin(Cliente::TB_NAME . " cl ON cl.id = eq.cliente_id ")
						->fetchAllObject();
	}
	
	
}

?>
