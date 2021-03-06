<?php

/**
 * Cuida das a��es do cliente
 *
 * @author apssouza
 */
class Cliente extends Model
{

	const TB_NAME = 'cliente';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'detalhes.php';
	const PG_EDITAR = 'form.php';

	public function getMatriz()
	{
		$filter = new Filter;
		$filter->where('ismatriz = 1 AND cliente_id =' . $this->id);
		$oUnidade = new ClienteUnidade();
		$filial = $oUnidade->getAll($filter);
		if (count($filial)) {
			return $filial[0];
		}

		$filter->where(' cliente_id = ' . $this->id)
				->orderBy('id ASC');
		$filial = $oUnidade->getAll($filter);

		return $filial[0];
	}

	public function store($data)
	{
		if ((isset($data['id']) && $data['id'] != '') || !empty($this->id)) {
			$this->deleteFiliais();
			$this->update($data, $this->id);
			return $this->id;
		}
		return $this->insert($data);
	}

	public function deleteFiliais()
	{
		$unidade = new ClienteUnidade;
		$unidade->deleteUnidadesByCliente($this->id);
	}

	public function getAllUnidades()
	{
		if (!isset($this->id)) {
			return array();
		}
		$oUnidade = new ClienteUnidade();
		$filter = new Filter;
		$filter->where(" cliente_id =" . $this->id);
		return $oUnidade->getAll($filter);
	}

	public function getUnidadesHtml()
	{
		$html = "<select name='unidade_id'>";
		$this->id = $_POST['idCliente'];
		foreach ($this->getAllUnidades() as $uni) {
			$html .="<option value='{$uni->id}'>{$uni->nome}</option>";
		}

		$html .="</select>";

		return $html;
	}

	/**
	 * Retorna somente as filiais, ou seja, n�o retorna a matriz
	 */
	public function getFiliais()
	{
		$matriz = $this->getMatriz();
		if (!$matriz) {
			return false;
		}
		$oUnidade = new ClienteUnidade();
		$filter = new Filter;
		$filter->where("id != {$matriz->id} AND cliente_id =" . $this->id);
		return $oUnidade->getAll($filter);
	}

}

?>
