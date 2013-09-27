<?php
$idEquip = isset($_GET['id']) ? $_GET['id'] : $argv[1];

require_once 'include/config.php';

//file_put_contents('/home/apssouza/Projetos/jobs/tmc/bgmonit.txt', $argv[1]);

$monitor = new Monitor();
$eq = new Equipamento($idEquip);

if (!$monitor->ping($eq->ip)) {
//	file_put_contents('/home/apssouza/Projetos/jobs/tmc/bgmonit.txt', $argv[1]);
//	$filename = '/home/apssouza/Projetos/jobs/tmc/log/bgmonit.txt';		
//	file_put_contents($filename, file_get_contents($filename) . ' - '.$argv[1]);
	if (!$monitor->estaFora($eq->id)) {
		$idChamado = $monitor->abrirChamado($eq);
		$monitor->registrarQueda($eq, $idChamado);
	}
} else {
	if ($monitor->estaFora($eq->id)) {
//		file_put_contents('/home/apssouza/Projetos/jobs/tmc/bgmonit.txt', $eq->id);
		var_dump($eq->id);
		$monitor->semiFecharChamado($eq);
		$oQueda = new Queda();
		$oQueda->fim($eq);
	}
}
exit(0);
?>
