<?php
$pasta = Authenticate::this_folder_name();
$user = ContainerDi::getObject('UsuarioCMS');
$con_cms_user = $user->find($con_cms_user->id);
?>
<!--<div id="menu">

	<div id="menu_user" class="ui-corner-all">
		<?php echo $con_cms_user->nome; ?><br />
		<img src="<?php echo $con_cms_user->get_imagem(null, true); ?>" class="img_usuario" align="left" />
		<a href="<?php echo DIR_CMS_HTM_ROOT;?>preferencias/perfil.php">meu perfil</a> | <a href="<?php echo DIR_CMS_HTM_ROOT;?>encerrar_sessao.php">sair</a>
		<a href="<?php echo DIR_CMS_HTM_ROOT;?>ajuda">ajuda</a>
	</div>
		
</div>    -->