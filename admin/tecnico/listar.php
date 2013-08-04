<?php 
include('../inc/inc_start.php'); 
require_once dirname(__FILE__).'/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina  = 'Tecnico';
$sqlWhere = '';
switch ($_GET['filtro']) {
	case 'aguarde':
		$sqlWhere = 'status=2';
		break;
	case 'aberto':
		$sqlWhere = 'status=1';
		break;
}

$objeto = new $classePagina();
$lista = $objeto->getAll();

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


<h1><strong>Lista de técnicos</strong></h1>


<?php

if(!$lista)
{
	?>
	<p>Nenhum item encontrado.</p>
	<?php
}
else
{
	?>
	<table class="tb_dados_desc">
	<thead>
		<tr>
			<th width="100">&nbsp;</th>
			<th>Nome</th>
			<th>Email</th>
			<th>Telefone</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($lista as $itemLista)
	{
		$bt_action = require '../inc/inc_botoes_edicao.php';
		?>
		<tr>
			<td><?php echo $bt_action;?></td>
			<td class="quando"><?php echo $itemLista->nome;?></td>
			<td>
				<?php echo $itemLista->email;?>
			</td>
			<td>
				<?php echo $itemLista->telefone;?>
			</td>			
		</tr>
		<?php 
	}
	?>
	</tbody>
	</table>
	<?php 
}
?>

</div>
</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
</body>
</html>
