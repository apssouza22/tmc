<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();


$classePagina = 'Estudo';

$objClassePg = new $classePagina($_GET['id']);
$oChamado = $objClassePg->getChamado();

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

				<h1>Detalhes do parceiro<span class="botoes"><?php echo $bt_action; ?></span></h1>


				<div class="caixa">
					<h3>Dados do parceiro</h3>

					<div class="field ">
						<label><span>Cliente:</span></label>
						<?php echo $oChamado->getCliente()->empresa; ?>
					</div>

					<div class="field ">
						<label><span>Titulo:</span></label>
						<?php echo $objClassePg->titulo ?>
					</div>
					<div class="field ">
						<label><span>Texto:</span></label>
						<?php echo $objClassePg->texto?>
					</div>

					<div class="field half">
						<label><span>Observa��es:</span></label>
						<?php echo $objClassePg->observacao; ?>
					</div>

				</div>

			</div>
		</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>