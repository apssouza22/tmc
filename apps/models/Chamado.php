<?php

/**
 * Cuida dos chamados
 *
 * @author apssouza
 */
class Chamado extends Model
{

	const TB_NAME = 'chamado';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'detalhes.php';
	const PG_EDITAR = 'chamado.php';

	/**
	 * Status do chamado
	 * 0 = fechado
	 * 1 = aberto
	 * 2 = semiaberto, aguardando descrição do problema, mais ja está funcionando
	 */
	public $status;

	public function abrirAutomatico($eq)
	{
		return $this->insert(array(
					'cliente_id' => $eq->cliente_id,
					'descricao' => 'Chamado aberto automaticamente por queda de equipamentos <br /> Eq. '.$eq->descricao.' <br> IP: '.$eq->ip,
		));
	}

//	public function fechar($id)
//	{
//		$oChamado = new Chamado;
//		return $oChamado->update(array(
//					'status' => 0
//						), $id);
//	}

	/**
	 * Fechamento automatico do chamado quando o equipamento valta a responder
	 * @param Object $eq objeto equipamento
	 */
	public function semiFecharChamado($eq)
	{
		$idChamado = $this->getChamadoByEquip($eq->id);
		if ($idChamado) {
			$update = $this->update(array(
				'status' => 2,
				'datafechamento' => date('Y-m-d H:i:s')
					), $idChamado);
			return $update;
		}
		return false;
	}

	private function getChamadoByEquip($id)
	{
		$filter = new Filter;
		$filter->where('equip_id =' . $id .' AND status = 1');
		$queda = new Queda;
		$aQuedas = $queda->getAll($filter);
		if ($aQuedas) {
			return $aQuedas[0]->chamado_id;
		}
		return false;
	}

	public function getAllCompleto(Filter $filter)
	{
		$oSelect = new Select('cl.empresa, ch.*', __CLASS__);
		return $oSelect->from(self::TB_NAME . ' ch')
						->innerJoin(Cliente::TB_NAME . " cl ON ch.cliente_id = cl.id ")
						->setFilter($filter)
						->fetchAllObject();
	}
	
	public function getCliente(){
		return new Cliente($this->cliente_id);
	}
	
	public function  getTecnico(){
		return new Tecnico($this->tecnico_id);
	}

	public function changeStatus()
	{
		$self = new self($_REQUEST['id_registro']);
		$status = $self->status ? 0 : 1;
		
		//== se estiver fechado, so muda o status ==//
		if($self->status == 0){
			return parent::changeStatus();
		}
		
		$this->update(array(
				'status' => $status,
				'datafechamento' => date('Y-m-d H:i:s')
			), $_REQUEST['id_registro']);
		
		return json_encode(array(
			0,
			'Alterado com sucesso'
		));
	}

}

?>
