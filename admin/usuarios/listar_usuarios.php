<?php 

include('../inc/inc_start.php'); 
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


<h1><strong>Listar usuários</strong></h1>


<?php
$lista = ContainerDi::getObject('UsuarioCMS')->getAll();

if($lista)
{
	?>
	<table class="tb_dados">
	<thead>
		<tr>
			<th width="100">&nbsp;</th>
			<th>ID</th>
			<th>Nome</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($lista as $usuario)
	{
		$bt_view = '<a href="detalhes_usuario.php?id=' . $usuario->id . '" class="bt_ico ico_view" title="detalhes"><em>detalhes</em></a>';
		$bt_edit = '<a href="editar_usuario.php?id=' . $usuario->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
		$bt_del = '<a href="excluir_usuario.php?id=' . $usuario->id . '" class="bt_ico ico_del" title="excluir"><em>excluir</em></a>';
		
		$botoes_edicao = $bt_view . $bt_edit . $bt_del;
		?>
		<tr>
			<td><?php echo $botoes_edicao;?></td>
			<td><?php echo $usuario->id;?></td>
			<td><?php echo $usuario->nome;?></td>
			<td><?php echo $usuario->email;?></td>
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
