<?php
require_once 'include/config.php';

//file_put_contents('/home/apssouza/Projetos/jobs/tmc/bgmonit.txt', $argv[1]);
//file_put_contents('/home/apssouza/Projetos/jobs/tmc/log/bgmonit.txt', $argv[1]);

$monitor = new Monitor();
$eq = new Equipamento($argv[1]);

if (!$monitor->ping($eq->ip)) {
	if (!$monitor->estaFora($eq->id)) {
		$idChamado = $monitor->abrirChamado($eq);
		$monitor->registrarQueda($eq, $idChamado);
	}
} else {
	if ($monitor->estaFora($eq->id)) {
		$monitor->semiFecharChamado($eq);
		$oQueda = new Queda();
		$oQueda->fim($eq);
	}
}
exit(0);
?>
