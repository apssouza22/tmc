<?php 
include('../inc/inc_start.php'); 
require_once dirname(__FILE__).'/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina  = 'Repetidora';

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


<h1><strong>Lista de repetidoras</strong></h1>


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
			<th width="130">&nbsp;</th>
			<th>Nome</th>
			<th>Zelador</th>
			<th>Telefone </th>
			<th>Síndico</th>
			<th>Telefone </th>
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
			<td ><?php echo $itemLista->nome;?></td>
			<td ><?php echo $itemLista->nome_zelador;?></td>
			<td>
				<?php echo $itemLista->telefone_zelador;?>
			</td>
			<td>
				<?php echo $itemLista->nome_sindico;?>
			</td>
			<td>
				<?php echo $itemLista->telefone_sindico;?>
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
