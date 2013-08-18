<title>TMC Sistema </title>

<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">


<?php
// prepara os arquivos CSS para serem carregados
// $vetor_css[][0] = media
// $vetor_css[][1] = caminho a partir da raíz do CMS
$vetor_css[] = array('screen', 'css/estilo.css');
$vetor_css[] = array('screen', 'js/ceebox/css/ceebox-min.css');
$vetor_css[] = array('screen', 'css/smoothness/jquery-ui-1.8.12.custom.css');
$vetor_css[] = array('screen', 'js/hmenu/skin-minha.css');
$vetor_css[] = array('screen', 'css/forms.css');
$vetor_css[] = array('screen', 'css/buttons.css');
$vetor_css[] = array('screen', 'css/menu.css');
$vetor_css[] = array('screen', 'css/paginacao.css');
$vetor_css[] = array('screen', 'css/tables.css');
$vetor_css[] = array('screen', 'css/topo.css');
$vetor_css[] = array('screen', 'css/upload.css');

foreach($vetor_css as $arquivo)
{
	$versao = filemtime(DIR_CMS_ROOT . $arquivo[1]);
	?>
	<link href="<?php echo DIR_CMS_HTM_ROOT; ?><?php echo $arquivo[1]; ?>?versao=<?php echo $versao; ?>" media="<?php echo $arquivo[0]; ?>" rel="stylesheet" type="text/css" />
	<?
}
?>



<script language="javascript">
	<!--
	var dir_cms_htm_root = "<?php echo DIR_CMS_HTM_ROOT;?>";
	_dynarch_menu_url = dir_cms_htm_root + "js/hmenu/";
	// -->
</script>

<?php
// prepara os arquivos JS para serem carregados
// $vetor_js[][0] = charset
// $vetor_js[][1] = caminho a partir da raíz do CMS
$vetor_js[] = array('', 'js/jquery-1.5.1.min.js');
$vetor_js[] = array('', 'js/jquery-ui-1.8.12.custom.min.js');
$vetor_js[] = array('', 'js/jquery-ui-timepicker-addon.js');
$vetor_js[] = array('', 'js/jquery.validate.js');
$vetor_js[] = array('', 'js/jquery.dataTables.js');
$vetor_js[] = array('', 'js/jquery.validate.js');
$vetor_js[] = array('', 'js/ceebox/js/jquery.ceebox-min.js');
$vetor_js[] = array('', 'js/hmenu/hmenu.js');
$vetor_js[] = array('utf-8', 'js/funcoes.js');

foreach($vetor_js as $arquivo)
{
	$versao = filemtime(DIR_CMS_ROOT . $arquivo[1]);
	?>
	<script src="<?php echo DIR_CMS_HTM_ROOT; ?><?php echo $arquivo[1]; ?>?versao=<?php echo $versao; ?>" charset="<?php echo $arquivo[0]; ?>" type="text/javascript"></script>
	<?
}
?>

