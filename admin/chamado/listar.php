<?php 
include('../inc/inc_start.php'); 
require_once dirname(__FILE__).'/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina  = 'Chamado';
$sqlWhere = '';
switch ($_GET['filtro']) {
	case 'aguarde':
		$sqlWhere = 'ch.status=2';
		break;
	case 'aberto':
		$sqlWhere = 'ch.status=1';
		break;
}

$objeto = new $classePagina();
$filter = new Filter();
$filter->orderBy('datacadastro DESC');
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


<h1><strong>Lista de chamados</strong></h1>


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
			<th>Data de Abertura</th>
			<th>Cliente</th>
			<th>Descrição</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($lista as $itemLista)
	{
		$classe_visibilidade = $itemLista->status==1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
		$bt_olho = '<a href="'.DIR_HTM_ROOT.'ajax.php" onclick="return toggle_exibir(\''.$classePagina.'\', ' . $itemLista->id . ', this)" class="bt_ico ico_olho ' . $classe_visibilidade . '" title="status"><em>visibilidade</em></a>';
		$bt_view = '<a href="detalhes.php?id=' . $itemLista->id . '" class="bt_ico ico_view" title="detalhes"><em>detalhes</em></a>';
		$bt_edit = '<a href="chamado.php?id=' . $itemLista->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
		$bt_olho = $itemLista->status==2 ? $bt_edit : $bt_olho ;
		$bt_action = $bt_olho . $bt_view . $bt_edit;
		
		if(time() > strtotime($itemLista->prazoentrega)){
			$class_status = 'red';
		}
		
		if(time() + 3600  > strtotime($itemLista->prazoentrega)){
			$class_status = 'yellow';
		}
		
		?>
		<tr class="<?=$class_status?>" >
			<td><?php echo $bt_action;?></td>
			<td class="quando"><em><?php echo $itemLista->dataabertura;?></em> <?php echo date('d/m/Y H:i:s', strtotime($itemLista->dataabertura));?></td>
			<td>
				<?php echo $itemLista->empresa;?>
			</td>
			<td>
				<?php echo htmlspecialchars_decode($itemLista->descricao);?>
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
