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
		$manutencao = new Manutencao();
		if (!$manutencao->isEmManutencao()) {
			$oEquipamento = new Equipamento();
			$all = $oEquipamento->getAllAtivos();
			foreach ($all as $eq) {
				$this->verificaStatus($eq->id);
			}
		}
		return true;
	}

	private function verificaStatus($epId)
	{
		 shell_exec("php ".DIR_ROOT."/bgmonitora.php {$epId} > /dev/null &");
	}

	public function estaFora($id)
	{
		if (!$this->allEqFora) {
			$oQueda = new Queda();
			$this->allEqFora = $oQueda->getEquipamentosFora();
		}
		return in_array($id, $this->allEqFora);
	}

	public function registrarQueda($eq, $idChamado)
	{
		$oQueda = new Queda();
		return $oQueda->inicio($eq, $idChamado);
	}

	public  function abrirChamado($eq)
	{
		$oChamado = new Chamado();
		return $oChamado->abrirAutomatico($eq);
	}

	public  function semiFecharChamado($eq)
	{
		$oChamado = new Chamado();
		return $oChamado->semiFecharChamado($eq);
	}

}

?>
