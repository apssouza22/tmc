<?php 
include('../inc/inc_start.php'); 
require_once dirname(__FILE__).'/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina  = 'Queda';

$objeto = new $classePagina();
$filter = new Filter();
$filter->orderBy('datainicio DESC');
$filter->limit(3000);
$filter->where($sqlWhere);
$lista = $objeto->getAllCompleto($filter);

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


<h1><strong>Lista de quedas</strong></h1>


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
			<th width="50">&nbsp;</th>
			<th>Data de inicio</th>
			<th>Data da volta</th>
			<th>Período fora</th>
			<th>Cliente</th>
			<th>Chamado</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($lista as $itemLista)
	{
		$classe_visibilidade = $itemLista->status==1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
		$bt_view = '<a href="detalhes.php?id=' . $itemLista->id . '" class="bt_ico ico_view" title="detalhes"><em>detalhes</em></a>';
		$bt_action = $bt_view . $bt_edit;
		?>
		<tr>
			<td><?php echo $bt_action;?></td>
			<td class="quando"><em><?php echo $itemLista->datainicio;?></em> <?php echo date('d/m/Y H:i:s', strtotime($itemLista->datainicio));?></td>
			<td>
				<?=$itemLista->datafim ? date('d/m/Y H:i:s', strtotime($itemLista->datafim)) : 'Ainda fora';?>
			</td>
			<td>
				<?php echo helpers\Date::intervalDiff($itemLista->datainicio, $itemLista->datafim ?: 'now' );?>
			</td>
			<td>
				<?=$itemLista->empresa?>
			</td>
			<td>
				<a href="<?=DIR_CMS_HTM_ROOT.'chamado/detalhes.php?id='. $itemLista->chamado_id;?>">Detalhes</a>
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
