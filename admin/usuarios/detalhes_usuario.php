<?php 

include('../inc/inc_start.php'); 
include('../inc/inc_start.php'); 
ContainerDi::getObject('UsuarioCMS')->autentica();
$id = $_GET['id'];
$usuario = ContainerDi::getObject('UsuarioCMS')->find(floor($id));

if(!$usuario->id) {
	header('Location: listar_usuarios.php');
}

foreach(get_object_vars($usuario) as $chave=>$valor)
{
	${$chave} = $valor;
}


$bt_edit = '<a href="editar_usuario.php?id=' . $usuario->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
$bt_del = '<a href="excluir_usuario.php?id=' . $usuario->id . '" class="bt_ico ico_del" title="excluir"><em>excluir</em></a>';

$botoes_edicao = $bt_edit . $bt_del;


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


<h1>Detalhes do usuário <span class="botoes"><?php echo $botoes_edicao;?></span></h1>


<div class="caixa">
<h3>Dados do usuário</h3>

    <div class="field">
        <label for="nome"><span>Nome</span></label>
		<?php echo $nome;?>
	</div>

	<div class="field">
		<label for="email"><span>E-mail</span></label> 
		<a href="mailto:<?php echo $email;?>"><?php echo $email;?></a>
	</div>

</div>	

<div class="caixa">
<h3>Permissões do usuário</h3>

	<?php
	$lista = ContainerDi::getObject('ModuloCMS')->getAll(' WHERE bool_ativo = 1');
	?>
	
	<table class="resumo" id="table_permissoes"> 
	<thead>
		<tr>
			<?php 
			foreach ($lista as $modulo)
			{
				?>
				<th><img src="<?php echo $modulo->imagem; ?>" title="<?php echo $modulo->nome; ?>" /></th>
				<?php
			}
			?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php 
			$vetor_perm = (array) $usuario->lista_permissoes();
			foreach ($lista as $modulo)
			{
				$name_check = 'perm_' . $modulo->id;
				
				?>
				<td>
					<?php
					if(in_array($modulo->id, $vetor_perm))
					{
						?>
						<img src="<?php echo DIR_CMS_HTM_ROOT; ?>imagens/check.gif" />
						<?php
					}
					else
					{
						?>
						&nbsp;
						<?php
					}
					?>
				</td>
				<?php
			}
			?>
		</tr>
	</tbody>
	</table>
				
</div>






</div>
</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
</body>
</html>
