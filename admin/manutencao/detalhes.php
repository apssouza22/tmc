<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();


$classePagina = 'Manutencao';

$objClassePg = new $classePagina($_GET['id']);

if (!$objClassePg->id) {
	header('Location: ' . constant("{$classePagina}::PG_LISTAR"));
	exit;
}

$man = new Manutencao();
$man->isEmManutencao();
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

				<h1>Detalhes<span class="botoes"><?php echo $bt_action; ?></span></h1>


				<div class="caixa">
					<h3>Dados da manutenção</h3>
					
					<div class="field alto full ">
						<label><span>Descrição:</span></label>
						<?php echo htmlspecialchars_decode($objClassePg->descricao)?>
					</div>

					<div class="field alto full">
						<label><span>Observações:</span></label>
						<?php echo htmlspecialchars_decode($objClassePg->observacao); ?>
					</div>
					
					<div class="field half">
						<label><span>Início:</span></label>
						<?php echo date('d/m/Y H:i',strtotime($objClassePg->inicio)); ?>
					</div>
					
					<div class="field half">
						<label><span>Fim:</span></label>
						<?php echo date('d/m/Y H:i',strtotime($objClassePg->fim)); ?>
					</div>

				</div>

			</div>
		</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
