<?php 
include('../inc/inc_start.php'); 
require_once dirname(__FILE__).'/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina  = 'Cliente';

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


<h1><strong>Lista de clientes</strong></h1>


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
			<th>Empresa</th>
			<th>Responsável</th>
			<th>Telefone</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($lista as $itemLista)
	{
		$classe_visibilidade = $itemLista->status==1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
		$bt_olho = '<a href="'.DIR_HTM_ROOT.'ajax.php" onclick="return toggle_exibir(\''.$classePagina.'\', ' . $itemLista->id . ', this)" class="bt_ico ico_olho ' . $classe_visibilidade . '" title="status"><em>visibilidade</em></a>';
		$bt_view = '<a href="detalhes.php?id=' . $itemLista->id . '" class="bt_ico ico_view" title="detalhes"><em>detalhes</em></a>';
		$bt_edit = '<a href="form.php?id=' . $itemLista->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
		$bt_action = $bt_olho . $bt_view . $bt_edit;
		?>
		<tr>
			<td><?php echo $bt_action;?></td>
			<td class="quando"><?php echo $itemLista->empresa;?></td>
			<td>
				<?php echo $itemLista->nome_gerente;?>
			</td>
			<td>
				<?php echo $itemLista->telefone;?>
			</td>
			<td>
				<?php echo $itemLista->email;?>
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
