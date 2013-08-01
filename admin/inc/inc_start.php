<?
//ALTERA��ES DE SEGURAN�A
ini_set('session.cookie_httponly', '1');
session_name(md5('seg' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
session_start();

date_default_timezone_set('America/Sao_Paulo');

if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], 'dev') !== false) {
	define('CMS_DB_NOME', 'tmc');
	define('CMS_DB_SENHA', '');
	define('CMS_DB_USUARIO', 'root');
	define('CMS_DB_HOST', 'localhost');
	define('CMS_DB_PORTA', '');
	
	$cmsPath = '/Meusprojetos/tmc/admin/'; // ra�z do CMS
} else {
	define('CMS_DB_NOME', 'tmc');
	define('CMS_DB_SENHA', 'usersalve');
	define('CMS_DB_USUARIO', 'salvesocialuser');
	define('CMS_DB_HOST', 'localhost');
	define('CMS_DB_PORTA', '');
	
	$cmsPath = '/Meusprojetos/tmc/admin/'; // ra�z do CMS
}

$host = $_SERVER['HTTP_HOST'] . '/';
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';

define('DIR_CMS_ROOT', $_SERVER['DOCUMENT_ROOT'] . $cmsPath);
define('DIR_CMS_HTM_ROOT', $protocol . $host . $cmsPath);
define('CMS_LIB', DIR_CMS_ROOT . 'libs/');

require_once dirname(__FILE__) . '/../libs/salve_admin/Loader.php';

//Registrando m�todo que carrega as classes din�micamente
$loader = new \helpers\Loader(array(
								///CMS_LIB . "dataBase/",
								CMS_LIB . 'image/',
								CMS_LIB . 'salve_admin/'
							));
$loader->register();

// caso tenha um usu�rio logado, disponibiliza o objeto respectivo
if(isset($_SESSION['con_usuario'])){
	$con_cms_user = unserialize($_SESSION['con_usuario']); 
}
