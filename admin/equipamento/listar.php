<?php 
include('../inc/inc_start.php'); 
require_once dirname(__FILE__).'/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina  = 'Equipamento';
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


<h1><strong>Lista de equipamentos</strong></h1>


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
			<th>Cliente</th>
			<th>IP</th>
			<th>Descrição</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$oQueda = new Queda();
	$allEqFora= $oQueda->getEquipamentosFora();
	foreach ($lista as $itemLista)
	{
		$classe_visibilidade = $itemLista->status==1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
		$bt_olho = '<a href="'.DIR_HTM_ROOT.'ajax.php" onclick="return toggle_exibir(\''.$classePagina.'\', ' . $itemLista->id . ', this)" class="bt_ico ico_olho ' . $classe_visibilidade . '" title="status"><em>visibilidade</em></a>';
		$bt_edit = '<a href="form.php?id=' . $itemLista->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
		$bt_excluir = '<a title="excluir" class=" bt_ico ico_del" href="'. DIR_CMS_HTM_ROOT .'excluir.php?id='.$itemLista->id.'&amp;classe=Equipamento"><em>excluir</em></a>';
		$bt_action = $bt_olho  . $bt_edit . $bt_excluir;
		$class_status = in_array($itemLista->id, $allEqFora) ? 'red' : '';
		?>
		<tr class="<?=$class_status?>">
			<td><?php echo $bt_action;?></td>
			<td class="quando"> <?php echo $itemLista->getCliente()->empresa?></td>
			<td>
				<?php echo $itemLista->ip;?>
			</td>
			<td>
				<?php echo $itemLista->descricao;?>
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
