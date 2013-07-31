<?php 

include('inc/inc_start.php'); 
ContainerDi::getObject('UsuarioCMS')->autentica();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd>
<html>
<head>
<?php include(DIR_CMS_ROOT . 'inc/inc_header.php'); ?>
</head>
<body>
<?php include(DIR_CMS_ROOT . 'inc/inc_topo.php'); ?>
<div id="central">
<?php include(DIR_CMS_ROOT . 'inc/inc_menu.php'); ?>
<div id="conteudo">


<h1><strong>Seja bem-vindo</strong></h1>

<?php
//$pasta='usuarios'; echo $pasta . '<br />';
//$vetor_menu = ModuloCMS::getVetor($pasta, 'usuarios');
//var_dump($vetor_menu);
?>

</div>
</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
</body>
</html>
