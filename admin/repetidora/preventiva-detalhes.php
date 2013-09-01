<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Preventiva';
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
		<?php include(DIR_CMS_ROOT . 'js/FCKeditor/fckeditor.php'); ?>
		<?php include(DIR_CMS_ROOT . 'inc/inc_uploader.php'); ?>
	</head>

	<body>
		<?php include(DIR_CMS_ROOT . 'inc/inc_topo.php'); ?>
		<div id="central">
			<?php include(DIR_CMS_ROOT . 'inc/inc_menu.php'); ?>
			<div id="conteudo">

				<?
				$itemLista = isset ($itemLista) ? $itemLista : $objClassePg; // a var item lista vai existir quando for uma listagem
				$bt_view = '<a href="'.constant("{$classePagina}::PG_LISTAR").'" class="bt_ico ico_list" title="listar"><em>listar</em></a>';	
				$bt_edit = '<a href="'.constant("{$classePagina}::PG_EDITAR").'?id=' . $itemLista->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
				$bt_del = '<a href="'.DIR_CMS_HTM_ROOT.'excluir.php?id=' . $itemLista->id . '&classe='.$classePagina.'" class="' . $classe_del . ' bt_ico ico_del" title="excluir"><em>excluir</em></a>';
				$bt_action = $bt_view . $bt_edit . $bt_del;

				?>

				<h1>Detalhes da repetidora<span class="botoes"><?php echo $bt_action; ?></span></h1>

					<div class="caixa">
						<h3>Dados</h3>
						<div class="field half">
							<label><span>Repetidora:</span> <strong><em>*</em></strong></label>
							<? echo $objClassePg->getRepetidora()->nome; ?>
						</div>

						<div class="field half">
							<label><span>Data da preventiva:</span><strong><em>*</em></strong></label>
							<? echo $objClassePg->getDataPreventiva()?>
						</div>
						
						<div class="field half">
							<label><span>Modelo roteador router sw:</span></label>
							<? echo $objClassePg->roteadorsw?>
						</div>

						<div class="field half">
							<label><span>Modelo roteador atendimento :</span></label>
							<? echo $objClassePg->roteadorra?>
						</div>

						<div class="field half">
							<label><span>Modelo do rack barrilete :</span></label>
							<? echo $objClassePg->modelo_rack?>
						</div>

						<div class="field half">
							<label><span>Quantidade de rack:</span></label>
							<? echo $objClassePg->qtd_rack?>
						</div>

						<div class="field half">
							<label><span>Quantidade de base de concreto:</span></label>
							<? echo $objClassePg->qtd_concreto?>
						</div>

						<div class="field half">
							<label><span>Quantidade de antenas 5.8 GHZ:</span></label>
							<? echo $objClassePg->qtd_antena?>
						</div>

						<div class="field ">
							<label><span>Croqui base de concreto & zona de fresnel:</span></label>
							<? echo $objClassePg->croqui_fresno?>
						</div>

						<div class="field ">
							<label><span>Modelo do nobreak:</span></label>
							<? echo $objClassePg->modelo_nobreak?>
						</div>

						<div class="field half">
							<label><span>Modelo da bateria:</span> </label>
							<? echo $objClassePg->modelo_bateria?>
						</div>
						<div class="field half">
							<label><span>Tensão de entrada :</span> </label>
							<? echo $objClassePg->tensao_entrada?>
						</div>
						<div class="field half">
							<label><span>Tensão de saida:</span> </label>
							<? echo $objClassePg->tensao_saida?>
						</div>

						<div class="field half">
							<label><span>Corrente de entrada :</span> </label>
							<? echo $objClassePg->corrente_entrada?>
						</div>
						<div class="field half">
							<label><span>Corrente de saida:</span> </label>
							<? echo $objClassePg->corrente_saida?>
						</div>

						<div class="field half">
							<label><span>01 - Teste de carga bat. :</span> </label>
							<? echo $objClassePg->teste_carga_1?>
						</div>
						<div class="field half">
							<label><span>02 - Teste de carga bat.:</span> </label>
							<? echo $objClassePg->teste_carga_2?>
						</div>
					</div>
					
			</div>
		</div>
		<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
