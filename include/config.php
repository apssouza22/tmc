<?php

date_default_timezone_set('America/Sao_Paulo');
header('P3P: CP="CAO PSA OUR"'); //resolvendo problema no IE na criação de cookie

if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ) {
	define('DB_NOME', 'tmc');
	define('DB_SENHA', '');
	define('DB_USUARIO', 'root');
	define('DB_HOST', 'localhost');
	define('DB_PORTA', '');

	define('PATH_SERV', $_SERVER['DOCUMENT_ROOT']);
	$sitePath = '/jobs/tmc/';
} else {
	define('DB_NOME', 'tmc');
	define('DB_SENHA', '');
	define('DB_USUARIO', 'root');
	define('DB_HOST', 'localhost');
	define('DB_PORTA', '');
	
		if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'salvesocial') !== false) {
			define('PATH_SERV', $_SERVER['DOCUMENT_ROOT']);
			$sitePath = '/kimberly/intimus/garota_verao/';
		}

		//comand line
		if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HOSTNAME'], 'salvesocial') !== false) {
			define('PATH_SERV', '/var/www/vhosts/salvesocial.com/httpdocs/kimberly/cha-de-bebe/');
		}
}

//testes com php UNIt
if (!defined('PATH_SERV')) {
	define('PATH_SERV', '/home/apssouza/Projetos/');
	$sitePath = '/jobs/tmc/';
}

$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

define('DIR_ROOT', PATH_SERV . $sitePath);
define('DIR_HTM_ROOT', 'http://'. $host. '/' . $sitePath);
define('LIB', DIR_ROOT . 'libs/');
define('MODEL', DIR_ROOT . 'apps/models/');
define('HELPER', DIR_ROOT . 'apps/helpers/');

require_once HELPER . 'Loader.php';

$loader = new Loader(array(
	HELPER,
	MODEL,
	LIB . 'dao/',
	DIR_ROOT . 'apps/'
		)
);
$loader->register();