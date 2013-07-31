<?php
require_once 'include/config.php';

/*
 * Recebe e manipula os ajax do projeto
 */

if (!isset($_REQUEST['classe'])) {
	throw new Exception('Informe uma classe');
	exit;
}

if (!isset($_REQUEST['method'])) {
	throw new Exception('Informe um m�todo');
	exit;
}

$class = $_REQUEST['classe'];
$method = $_REQUEST['method'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	unset($_POST['classe']);
	unset($_POST['method']);
} else {
	unset($_GET['classe']);
	unset($_GET['method']);
}
$class = new $class;
echo $class->{$method}();