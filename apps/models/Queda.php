<?php

/**
 * Cuida das perdas de conexão com os equipamentos
 *
 * @author apssouza
 */
class Queda extends Model
{
	const TB_NAME = 'queda';
	const PG_DETALHE = 'detalhes.php';
	const PG_LISTAR  = 'listar.php';
	const PG_EDITAR = 'listar.php';

	public function getEquipamentosFora()
	{
		$filter = new Filter();
		$filter->where(' status = 1');
		$all = $this->getAll($filter);
		$aEquip = array();
		foreach ($all as $value) {
			$aEquip[] = $value->equip_id;
		}
		return $aEquip;
	}

	public function inicio($eq, $idchamado)
	{
		return $this->insert(array(
			'chamado_id' => $idchamado,
			'equip_id' => $eq->id,
		));
	}

	public function fim($eq)
	{
		return $this->updateByEquip(array(
			'status' => 0,
			'datafim' => date('Y-m-d H:i:s')
		),$eq->id);
	}
	
	private function updateByEquip($data, $id){
		$update = new Update(self::TB_NAME);
		return $update->data($data)
				->where('equip_id = :equip_id', array(
					'equip_id' => $id
				))
				->save();
	}
	
	public function getAllCompleto(Filter $filter, $cliente = null)
	{
		$cliente = $cliente ? ' AND cl.id ='.$cliente : '';
		$oSelect = new Select('cl.empresa, eq.cliente_id, eq.descricao, eq.ip, ch.problema, q.*', __CLASS__);
		return $oSelect->from(self::TB_NAME . ' q')
						->innerJoin(Equipamento::TB_NAME . " eq ON eq.id = q.equip_id  ")
						->innerJoin(Cliente::TB_NAME . " cl ON cl.id = eq.cliente_id ".$cliente )
						->innerJoin(Chamado::TB_NAME . " ch ON ch.id = q.chamado_id ")
						->setFilter($filter)
						->fetchAllObject();
	}
	
	public function getQuedaCompleto($id){
		$filter = new Filter;
		$filter->where("q.id= $id");
		$aQuedas = $this->getAllCompleto($filter);
		return isset($aQuedas[0]) ? $aQuedas[0] : false;
	}

}

?>
