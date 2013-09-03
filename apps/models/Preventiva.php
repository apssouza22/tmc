<?php

/**
 * Cuida das preventivas
 *
 * @author apssouza
 */
class Preventiva extends Model
{
	const TB_NAME = 'preventiva';
	const PG_LISTAR = 'preventiva-listar.php';
	const PG_DETALHE = 'preventiva-detalhes.php';
	const PG_EDITAR = 'preventiva-form.php';
	
	const PREVENTIVA_INTERVALO = '10';

	public function getRepetidora(){
		return new Repetidora($this->repetidora_id);
	}
	
	public function getDataPreventiva(){
		$data = explode(' ', $this->datapreventiva);
		$dataf = explode('-', $data[0]);
		return implode('/', array_reverse($dataf)) . ' '.$data[1];
	}
	
	public function getLista(){
		$oSelect = new Select('r.nome repetidora, p.datapreventiva, p.id', __CLASS__);
		return $oSelect->from(Preventiva::TB_NAME.' p')
						->innerJoin(Repetidora::TB_NAME . " r ON r.id = p.repetidora_id ")
						->fetchAllObject();
	}
	
	public function hasPreventivaAtrasada($repetidora){
		$filter = new Filter();
		$filter->where("repetidora_id =$repetidora AND datapreventiva > ( NOW() - INTERVAL ".self::PREVENTIVA_INTERVALO." DAY )");
		return !$this->count($filter);
	}
	
	
	public function lastPreventiva($repetidora){
		$filter = new Filter();
		$filter->orderBy('datapreventiva DESC')
			->where("repetidora_id =$repetidora");
		return $this->getAll($filter);
	}
	
	public function getRepetidoraComPreventivaFeita(){
		$oSelect = new Select('p.repetidora_id', __CLASS__);
		$ids = $oSelect->from(Preventiva::TB_NAME.' p')
						->groupBy("repetidora_id")
						->fetchAll();
		$return = array();
		foreach ($ids as $value) {
			array_push($return, $value['repetidora_id']);
		}
		return $return;
	}
	
	
}

?>
