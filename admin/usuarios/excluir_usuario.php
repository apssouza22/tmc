<?php

include('../inc/inc_start.php');
ContainerDi::getObject('UsuarioCMS')->autentica();


$usuario = ContainerDi::getObject('UsuarioCMS')->find(floor($_GET['id']));
if (isset($usuario->id)) {
	$usuario->delete($usuario->id);
}

header('Location: listar_usuarios.php');
?>
