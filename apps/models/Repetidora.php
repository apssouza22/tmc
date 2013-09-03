<?php


/**
 * Cuida dos cadastros de tecnicos
 *
 * @author apssouza
 */
class Repetidora extends Model
{
	const TB_NAME = 'repetidora';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'detalhes.php';
	const PG_EDITAR = 'form.php';
	const PG_PASTA = 'repetidora';
	
	public function getSentinela(){
		return new Equipamento($this->equipamento_id);
		//var_dump($equip)
	}
	
	public function getUltimaPreventiva(){
		$preventiva = new Preventiva();
		if($oPrev = $preventiva->hasPreventivaAtrasada($this->id)){
			return $oPrev;
		}
		return false;
	}
	
	public function hasPreventivaAtrasada(){
		$prev = new Preventiva();
		$aRepId = $prev->getRepetidoraComPreventivaFeita();
		if(in_array($this->id, $aRepId)){
			return $prev->hasPreventivaAtrasada($this->id);
		}
		return false;
	}
}

?>
