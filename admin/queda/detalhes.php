<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();


$classePagina = 'Queda';

$objClassePg = new $classePagina();
$objClassePg = $objClassePg->getQuedaCompleto($_GET['id']);

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
				$bt_view = '<a href="'.  constant("{$classePagina}::PG_LISTAR") . '" class="bt_ico ico_list" title="detalhes"><em>detalhes</em></a>';
				$bt_action = $bt_view ;
				?>

				<h1>Detalhes da queda<span class="botoes"><?php echo $bt_action; ?></span></h1>


				<div class="caixa">
					<h3>Dados da queda</h3>

					<div class="field ">
						<label><span>Empresa:</span></label>
						
						<a href="<?=DIR_CMS_HTM_ROOT.'cliente/detalhes.php?id='. $objClassePg->cliente_id;?>"><?php echo $objClassePg->empresa; ?></a>
					</div>

					<div class="field half ">
						<label for="descricao"><span>Data Início:</span></label>
						<?php echo date('d/m/Y H:i:s', strtotime($objClassePg->datainicio));?>
					</div>

					<div class="field half">
						<label><span>Data da volta:</span></label>
						<?=$objClassePg->datafim ? date('d/m/Y H:i:s', strtotime($objClassePg->datafim)) : 'Ainda fora';?>
					</div>

					<div class="field half">
						<label><span>Período fora:</span></label>
						<?php echo helpers\Date::intervalDiff($objClassePg->datainicio, $objClassePg->datafim ?: 'now' );?>
					</div>

					<div class="field half">
						<label><span>Equipamento:</span></label>
						<?=$objClassePg->descricao?>
					</div>

					<div class="field half">
						<label><span>Equipamento IP:</span></label>
						<?=$objClassePg->ip?>
					</div>

					<div class="field half">
						<label><span>Motivo:</span></label>
						<?=$objClassePg->problema == 'NULL' ? 'Não informado' : $objClassePg->problema?>
					</div>

					<div class="field half">
						<label><span>Chamado:</span></label>
						<a href="<?=DIR_CMS_HTM_ROOT.'chamado/detalhes.php?id='. $objClassePg->chamado_id;?>">Detalhes</a>
					</div>


					<div class="field half">
						<label><span>Status:</span></label>
						<?php $status = array('Fechado', 'Aberto' ); 
						echo $status[$objClassePg->status];
						?>
					</div>

				</div>


				

			</div>
		</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
