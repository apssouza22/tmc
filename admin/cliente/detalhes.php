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

$oMatriz = $objClassePg->getMatriz();
$aFilial = $objClassePg->getFiliais();
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
				$bt_olho = '<a href="' . DIR_HTM_ROOT . 'ajax.php" onclick="return toggle_exibir(\'' . $classePagina . '\', ' . $objClassePg->id . ', this)" class="bt_ico ico_olho ' . $classe_visibilidade . '" title="status"><em>visibilidade</em></a>';
				$bt_view = '<a href="' . constant("{$classePagina}::PG_LISTAR") . '" class="bt_ico ico_list" title="detalhes"><em>detalhes</em></a>';
				$bt_edit = '<a href="form.php?id=' . $objClassePg->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
				$bt_action = $bt_olho . $bt_view . $bt_edit;
				?>

				<h1>Detalhes do Cliente<span class="botoes"><?php echo $bt_action; ?></span></h1>


				<div class="caixa">
					<h3>Dados do cliente</h3>

					<div class="field ">
						<label><span>Empresa:</span></label>
						<?php echo $objClassePg->empresa; ?>
					</div>

					<div class="field ">
						<label><span>Responsável:</span></label>
						<?php echo $objClassePg->nome_gerente ?>
					</div>
					<div class="field ">
						<label><span>E-mail:</span></label>
						<?php echo $objClassePg->email ?>
					</div>

					<div class="field half">
						<label><span>Telefone:</span></label>
						<?php echo $objClassePg->telefone; ?>
					</div>

				</div>
				<? if ($oMatriz) { ?>
					<div class="caixa">
						<h3>Matriz</h3>
						
						<div class="field ">
							<label><span>Unidade:</span></label>
							<?php echo $oMatriz->nome?>
						</div>
						<div class="field ">
							<label><span>Responsável:</span></label>
							<?php echo $oMatriz->nome_responsavel ?>
						</div>
						<div class="field ">
							<label><span>E-mail:</span></label>
							<?php echo $oMatriz->email ?>
						</div>

						<div class="field half">
							<label><span>Telefone:</span></label>
							<?php echo $oMatriz->telefone; ?>
						</div>

						<div class="field half">
							<label><span>CEP:</span></label>
							<?php echo $oMatriz->cep; ?>
						</div>

						<div class="field">
							<label><span>Endereço:</span></label>
							<?php echo $oMatriz->endereco; ?>
						</div>

						<div class="field half">
							<label><span>Bairro: </span></label>
							<?php echo $oMatriz->bairro; ?>
						</div>

						<div class="field half">
							<label><span>Cidade:</span></label>
							<?php echo $oMatriz->cidade; ?>
						</div>

						<div class="field half">
							<label><span>Estado:</span></label>
							<?php echo $oMatriz->estado;
							?>
						</div>
						<div class="field half">
							<label><span>Velocidade lan-to-lan:</span></label>
							<?php echo $oMatriz->velocidadelan;
							?>
						</div>
						<div class="field half">
							<label><span>Velocidade porta ip:</span></label>
							<?php echo $oMatriz->velocidadeip;
							?>
						</div>
						<? if($oMatriz->parceiro_id) {?>
						<div class="field half">
							<label><span>Parceiro:</span></label>
							<a href="<?=DIR_CMS_HTM_ROOT .'parceiro/detalhes.php?id=' . $oMatriz->parceiro_id ?>"><?php echo $oMatriz->getParceiro()->nome?></a>
						</div>
						<?}?>
					</div>

					<?
				}

				if ($aFilial) {
					foreach ($aFilial as $filial) {
						?>
						<div class="caixa">
							<h3>Dados da unidade  <a class="ajax-delete-unidade" data-id="<?php echo $filial->id; ?>" onclick="deletarUnidade(this); return false;">deletar unidade</a></h3>

							<div class="field ">
								<label><span>Unidade:</span></label>
								<?php echo $filial->nome; ?>
							</div>

							<div class="field ">
								<label><span>Responsável:</span></label>
								<?php echo $filial->nome_responsavel ?>
							</div>
							<div class="field ">
								<label><span>E-mail:</span></label>
								<?php echo $filial->email ?>
							</div>

							<div class="field half">
								<label><span>Telefone:</span></label>
								<?php echo $filial->telefone; ?>
							</div>

							<div class="field half">
								<label><span>CEP:</span></label>
								<?php echo $filial->cep; ?>
							</div>

							<div class="field">
								<label><span>Endereço:</span></label>
								<?php echo $filial->endereco; ?>
							</div>

							<div class="field half">
								<label><span>Bairro: </span></label>
								<?php echo $filial->bairro; ?>
							</div>

							<div class="field half">
								<label><span>Cidade:</span></label>
								<?php echo $filial->cidade; ?>
							</div>

							<div class="field half">
								<label><span>Estado:</span></label>
								<?php echo $filial->estado;
								?>
							</div>
							<div class="field half">
								<label><span>Velocidade lan-to-lan:</span></label>
								<?php echo $filial->velocidadelan;
								?>
							</div>
							<div class="field half">
								<label><span>Velocidade porta ip:</span></label>
								<?php echo $filial->velocidadeip;
								?>
							</div>

						</div>
					<? } ?>
				<? } ?>

			</div>
		</div>
		<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
		<script src="../js/admin.js"></script>
	</body>
</html>
