<?php 
include('../inc/inc_start.php'); 
require_once dirname(__FILE__).'/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina  = 'Preventiva';

$objeto = new $classePagina();
$lista = $objeto->getLista();

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


<h1><strong>Lista de preventivas</strong></h1>


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
			<th>Data</th>
			<th>Repetidora</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($lista as $itemLista)
	{
				$itemLista = isset ($itemLista) ? $itemLista : $objClassePg; // a var item lista vai existir quando for uma listagem
				$bt_view = '<a href="'.constant("{$classePagina}::PG_DETALHE").'?id=' . $itemLista->id . '" class="bt_ico ico_view" title="detalhes"><em>detalhes</em></a>';
				$bt_edit = '<a href="'.constant("{$classePagina}::PG_EDITAR").'?id=' . $itemLista->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
				$bt_del = '<a href="'.DIR_CMS_HTM_ROOT.'excluir.php?id=' . $itemLista->id . '&classe='.$classePagina.'" class="' . $classe_del . ' bt_ico ico_del" title="excluir"><em>excluir</em></a>';
				$bt_action = $bt_view . $bt_edit . $bt_del;

		?>
		<tr>
			<td><?php echo $bt_action;?></td>
			<td width="200" class="quando"><em><?php echo $itemLista->datapreventiva;?></em><?php echo $itemLista->getDataPreventiva();?></td>
			<td ><?php echo $itemLista->repetidora;?></td>
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
