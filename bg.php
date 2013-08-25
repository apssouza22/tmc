<?php
require_once 'include/config.php';
while (true) {
	file_put_contents('/home/apssouza/Projetos/jobs/tmc/bgfile2.txt', date('his'));
	$monitor = new Monitor();
	$monitor->monitora();
	sleep(30); //30 segundos
	exit(0);
}
?>
