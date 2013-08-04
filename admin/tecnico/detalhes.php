<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();


$classePagina = 'Tecnico';

$objClassePg = new $classePagina($_GET['id']);


if (!$objClassePg->id) {
	header('Location: ' . constant("{$classePagina}::PG_LISTAR"));
	exit;
}
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
				<?
				$bt_action = require '../inc/inc_botoes_edicao.php';
				?>

				<h1>Detalhes do T�cnico<span class="botoes"><?php echo $bt_action; ?></span></h1>


				<div class="caixa">
					<h3>Dados do t�cnico</h3>

					<div class="field ">
						<label><span>Nome:</span></label>
						<?php echo $objClassePg->nome; ?>
					</div>

					<div class="field ">
						<label><span>E-mail:</span></label>
						<?php echo $objClassePg->email ?>
					</div>
					<div class="field ">
						<label><span>Etelefone:</span></label>
						<?php echo $objClassePg->telefone?>
					</div>

					<div class="field half">
						<label><span>RG:</span></label>
						<?php echo $objClassePg->rg; ?>
					</div>

				</div>
				
			</div>
		</div>
		<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
