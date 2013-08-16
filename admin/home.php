<?php
include('inc/inc_start.php');
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

			<div id="menu">
				<?php
				$pasta = Authenticate::this_folder_name();
				$user = ContainerDi::getObject('UsuarioCMS');
				$con_cms_user = $user->find($con_cms_user->id);
				?>
				<div id="menu_user" class="ui-corner-all">
					<?php echo $con_cms_user->nome; ?><br />
					<img src="<?php echo $con_cms_user->get_imagem(null, true); ?>" class="img_usuario" align="left" />
					<a href="<?php echo DIR_CMS_HTM_ROOT; ?>preferencias/perfil.php">meu perfil</a> | <a href="<?php echo DIR_CMS_HTM_ROOT; ?>encerrar_sessao.php">sair</a>
					<a href="<?php echo DIR_CMS_HTM_ROOT; ?>ajuda">ajuda</a>
				</div>
			</div>
			<div id="conteudo">


				<h1><strong>Seja bem-vindo</strong></h1>

				<?php
//$pasta='usuarios'; echo $pasta . '<br />';
//$vetor_menu = ModuloCMS::getVetor($pasta, 'usuarios');
//var_dump($vetor_menu);
				?>

			</div>
		</div>
		<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
