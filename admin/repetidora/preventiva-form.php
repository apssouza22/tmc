<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Preventiva';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar preventiva';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Nova preventiva';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new $classePagina($id);

if ($_POST) {
	$data = explode(' ', $_POST['datapreventiva']);
	$dataf = explode('/', $data[0]);
	$dataf = implode('-', array_reverse($dataf)) . ' '.$data[1];
	$_POST['datapreventiva'] = $dataf;
	$id = $objClassePg->store($_POST);
	header('Location: ' . constant("{$classePagina}::PG_DETALHE") . '?id=' . $id);
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

				<h1><?php echo $tituloPagina; ?> <span class="botoes"><em>*</em> Campos obrigatórios</span></h1>

				<?php Utils::escreve_alerta(); ?>


				<form method="post" name="form_ins" id="form_ins" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return checar(this)">
					<input type="hidden" name="id" value="<?php echo $id; ?>" />

					<div class="caixa">
						<h3>Dados</h3>
						<div class="field half">
							<label><span>Repetidora:</span> <strong><em>*</em></strong></label>
							<select name="repetidora_id" class="obr" nomecampo="Repetidora" >
								<option value=""></option>
								<?
								$oRep = new Repetidora();
								$aRep = $oRep->getAll();
								foreach ($aRep as $value) {
									$selected = $objClassePg->repetidora_id == $value->id ?
											'selected="selected"':'';
									echo "<option value='{$value->id}' $selected >{$value->nome}</option>";
								}
								?>
							</select>
						</div>

						<div class="field half">
							<label><span>Data da preventiva:</span><strong><em>*</em></strong></label>
							<input type="text" name="datapreventiva" class="obr datetimepicker" maxlength="255" value="<?= $objClassePg->getDataPreventiva() ?>"></input>
						</div>
						
						<div class="field half">
							<label><span>Modelo roteador router sw:</span></label>
							<input type="text" name="roteadorsw" maxlength="255" value="<?= $objClassePg->roteadorsw ?>"></input>
						</div>

						<div class="field half">
							<label><span>Modelo roteador atendimento :</span></label>
							<input type="text" name="roteadorra" maxlength="255" value="<?= $objClassePg->roteadorra ?>"></input>
						</div>

						<div class="field half">
							<label><span>Modelo do rack barrilete :</span></label>
							<input type="text" name="modelo_rack" maxlength="255" value="<?= $objClassePg->modelo_rack ?>"></input>
						</div>

						<div class="field half">
							<label><span>Quantidade de rack:</span></label>
							<input type="text" name="qtd_rack" maxlength="4" class="number" value="<?= $objClassePg->qtd_rack ?>"></input>
						</div>

						<div class="field half">
							<label><span>Quantidade de base de concreto:</span></label>
							<input type="text" name="qtd_concreto" maxlength="4"  class="number" value="<?= $objClassePg->qtd_concreto ?>"></input>
						</div>

						<div class="field half">
							<label><span>Quantidade de antenas 5.8 GHZ:</span></label>
							<input type="text" name="qtd_antena" maxlength="4" class="number" value="<?= $objClassePg->qtd_antena ?>"></input>
						</div>

						<div class="field ">
							<label><span>Croqui base de concreto & zona de fresnel:</span></label>
							<input type="text" name="croqui_fresno" maxlength="255" value="<?= $objClassePg->croqui_fresno ?>"></input>
						</div>

						<div class="field ">
							<label><span>Modelo do nobreak:</span></label>
							<input type="text" name="modelo_nobreak" maxlength="255" value="<?= $objClassePg->modelo_nobreak ?>"></input>
						</div>

						<div class="field half">
							<label><span>Modelo da bateria:</span> </label>
							<input type="text" name="modelo_bateria" maxlength="255" value="<?= $objClassePg->modelo_bateria ?>"></input>
						</div>
						<div class="field half">
							<label><span>Tensão de entrada :</span> </label>
							<input type="text" name="tensao_entrada" maxlength="255" value="<?= $objClassePg->tensao_entrada ?>"></input>
						</div>
						<div class="field half">
							<label><span>Tensão de saida:</span> </label>
							<input type="text" name="tensao_saida" maxlength="255" value="<?= $objClassePg->tensao_saida ?>"></input>
						</div>

						<div class="field half">
							<label><span>Corrente de entrada :</span> </label>
							<input type="text" name="corrente_entrada" maxlength="255" value="<?= $objClassePg->corrente_entrada ?>"></input>
						</div>
						<div class="field half">
							<label><span>Corrente de saida:</span> </label>
							<input type="text" name="corrente_saida" maxlength="255" value="<?= $objClassePg->corrente_saida ?>"></input>
						</div>

						<div class="field half">
							<label><span>01 - Teste de carga bat. :</span> </label>
							<input type="text" name="teste_carga_1" maxlength="255" value="<?= $objClassePg->teste_carga_1 ?>"></input>
						</div>
						<div class="field half">
							<label><span>02 - Teste de carga bat.:</span> </label>
							<input type="text" name="teste_carga_2" maxlength="255"  value="<?= $objClassePg->teste_carga_2 ?>"></input>
						</div>
					</div>
					

					<div class="field full controles">
						<a href="#" onclick="$('#form_ins').submit();
						return false;" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-disk"></span>Salvar</a>
						<a href="<?php echo $linkCancelar; ?>" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-closethick"></span>Cancelar</a>
						<input type="submit" class="submit" />
					</div>
				</form>
			</div>
		</div>
		<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
