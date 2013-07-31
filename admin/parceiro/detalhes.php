<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();


$classePagina = 'Cliente';

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
				$classe_visibilidade = $objClassePg->status == 1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
				$bt_olho = '<a href="'.DIR_HTM_ROOT.'ajax.php" onclick="return toggle_exibir(\''.$classePagina.'\', ' . $objClassePg->id . ', this)" class="bt_ico ico_olho ' . $classe_visibilidade . '" title="status"><em>visibilidade</em></a>';
				$bt_view = '<a href="'.  constant("{$classePagina}::PG_LISTAR") . '" class="bt_ico ico_list" title="detalhes"><em>detalhes</em></a>';
				$bt_edit = '<a href="form.php?id=' . $objClassePg->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
				$bt_action = $bt_olho . $bt_view . $bt_edit;
				?>

				<h1>Detalhes do chamado<span class="botoes"><?php echo $bt_action; ?></span></h1>


				<div class="caixa">
					<h3>Dados do cliente</h3>

					<div class="field ">
						<label><span>Empresa:</span></label>
						<?php echo $objClassePg->empresa; ?>
					</div>

					<div class="field ">
						<label><span>Responsável:</span></label>
						<?php echo $objClassePg->nome_responsavel ?>
					</div>
					<div class="field ">
						<label><span>E-mail:</span></label>
						<?php echo $objClassePg->email?>
					</div>

					<div class="field half">
						<label><span>Telefone:</span></label>
						<?php echo $objClassePg->telefone; ?>
					</div>
					
					<div class="field half">
						<label><span>CEP:</span></label>
						<?php echo $objClassePg->cep; ?>
					</div>

					<div class="field">
						<label><span>Endereço:</span></label>
						<?php echo $objClassePg->endereco; ?>
					</div>

					<div class="field half">
						<label><span>Bairro: </span></label>
						<?php echo $objClassePg->bairro; ?>
					</div>

					<div class="field half">
						<label><span>Cidade:</span></label>
						<?php echo $objClassePg->cidade; ?>
					</div>

					<div class="field half">
						<label><span>Status:</span></label>
						<?php echo $objClassePg->estado;
						?>
					</div>

				</div>

			</div>
		</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
