<?php

include('inc/inc_start.php');
require_once dirname(__FILE__).'/../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classe = $_GET['classe'];
$objeto = new $classe($_GET['id']);
if ($objeto->id) {
	try{
		$objeto->delete(); 
	}  catch (Exception $e ){
		if (!defined($classe . '::PG_PASTA')) {
			$location = constant("{$classe}::PG_LISTAR");
		} else {
			$location = constant("{$classe}::PG_PASTA") . '/' . constant("{$classe}::PG_LISTAR");
		}
		echo "<script>alert('Não é possível deletar o registro.')
			window.location.href='$location '</script>";
		exit;
	}
}

if (!defined($classe . '::PG_PASTA')) {
	header('Location: ' . constant("{$classe}::PG_LISTAR"));
} else {
	header('Location: ' . constant("{$classe}::PG_PASTA") . '/' . constant("{$classe}::PG_LISTAR"));
}

?>
