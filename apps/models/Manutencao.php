<?php

/**
 * Cuida do cadastro de manutenção
 *
 * @author apssouza
 */
class Manutencao extends Model
{
	const TB_NAME = 'manutencao';
	const PG_DETALHE = 'detalhes.php';
	const PG_LISTAR  = 'listar.php';
	const PG_EDITAR = 'form.php';
	const PG_PASTA = 'manutencao';

	public function changeStatus()
	{
		$self = new self($_REQUEST['id_registro']);
		$status = $self->status ? 0 : 1;

		$this->update(array(
			'status' => $status,
			'fim' => date('Y-m-d H:i:s')
				), $_REQUEST['id_registro']);

		return json_encode(array(
			0,
			'Alterado com sucesso'
		));
	}
	
	/**
	 * Verifica se tem alguma manutenção aberta 
	 */
	public function isEmManutencao(){
		$now = date('Y-m-d h:i:s');
		$filter = new Filter();
		$filter->where(" (inicio < '{$now}' AND fim > '{$now}') AND status = 1  ");
		return (boolean) $this->count($filter);
	}

}

?>
