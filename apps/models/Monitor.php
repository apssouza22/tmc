<?php

/**
 * Cuida da monitoração dos equipamentos
 *
 * @author apssouza
 */
class Monitor extends Model
{

	const TB_NAME = 'radio';
	private $allEqFora;

	public function ping($ip)
	{
		$pingando = shell_exec("ping -c 1 $ip");
		if (preg_match('/bytes from/', $pingando)) {
			return true;
		}
		return false;
	}

	public function monitora()
	{
		$oEquipamento = new Equipamento();
		$all = $oEquipamento->getAllAtivos();
		foreach ($all as $eq){
			if(!$this->ping($eq->ip)){
				if(!$this->estaFora($eq->id)){
					$idChamado = $this->abrirChamado($eq);
					$this->registrarQueda($eq, $idChamado);
				}
			}else{
				if($this->estaFora($eq->id)){
					$this->semiFecharChamado($eq);
					$oQueda = new Queda();
					$oQueda->fim($eq);
				}
			}
		}
		return true;
	}
	
	public  function estaFora($id){
		if(!$this->allEqFora){
			$oQueda = new Queda();
			$this->allEqFora= $oQueda->getEquipamentosFora();
		}
		return in_array($id, $this->allEqFora);
	}
	
	private function registrarQueda($eq, $idChamado){
		$oQueda = new Queda();
		return $oQueda->inicio($eq, $idChamado);
	}
	
	private function abrirChamado($eq){
		$oChamado = new Chamado();
		return $oChamado->abrirAutomatico($eq);
	}
	
	private function semiFecharChamado($eq){
		$oChamado = new Chamado();
		return $oChamado->semiFecharChamado($eq);
	}

}

?>
