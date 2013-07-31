<?php 

include('../inc/inc_start.php'); 
ContainerDi::getObject('UsuarioCMS')->autentica();


$usuario = ContainerDi::getObject('UsuarioCMS')->find($con_cms_user->id);
$nome = $usuario->nome;
$email = $usuario->email;


$bt_edit = '<a href="editar_perfil.php" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';

$botoes_edicao = $bt_edit;

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


<h1>Meu perfil <span class="botoes"><?php echo $botoes_edicao;?></span></h1>


<div class="caixa">
<h3>Dados do usuário</h3>

    <div class="field">
        <label for="nome"><span>Nome</span></label>
		<?php echo $nome;?>
	</div>

	<div class="field">
		<label for="email"><span>E-mail</span></label> 
		<?php echo $email;?>
	</div>

	<div class="field">
		<label>Foto</label>
		<?php
		if(!$usuario->arquivo)
		{
			?>
			<em>Não tem</em>
			<?php
		}
		else
		{
			?>
			<span id="container_foto_del">
				<a href="<?php echo $usuario->imagem; ?>" class="bt_ico ico_view ceebox" title="visualizar"><em>visualizar</em></a>
				<a href="#" onclick="exclui_foto_usuario(<?php echo $con_cms_user->id; ?>)" class="bt_ico ico_del_ajax" title="excluir"><em>excluir</em></a>
			</span>
			<?php
		}
		?>
	</div>
</div>	

<div class="caixa">
<h3>Permissões do usuário</h3>

	<?php
	// lista os módulos possíveis
	$lista = ContainerDi::getObject('ModuloCMS')->getAll("WHERE bool_ativo = 1");
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
