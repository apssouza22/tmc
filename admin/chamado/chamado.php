<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Chamado';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar Chamado';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Novo Chamado';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new $classePagina($id);

if ($_POST) {
	$dateTime = new DateTime();
	$dateInterval = new DateInterval('P0D');
	$dateInterval->h =$_POST['sla'];
	$_POST['prazoentrega'] = $dateTime->add($dateInterval )->format('Y-m-d H:i:s');
	$_POST['sla'] = null;
	$objClassePg->store($_POST);
	header('Location: ' . constant("{$classePagina}::PG_DETALHE") . '?id=' . $id);
	exit;
	
} else {
	
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
							<label><span>Cliente:</span> <strong><em>*</em></strong></label>
							<select class="obr" name="cliente_id" nomecampo="Cliente">
								<option value=""></option>
								<?
								$oCliente = new Cliente();
								$aClientes = $oCliente->getAll();
								foreach ($aClientes as $value) {
									$selected = $objClassePg->getCliente()->id == $value->id ?
											'selected="selected"':'';
									echo "<option value='{$value->id}' $selected >{$value->empresa}</option>";
								}
								?>
							</select>
						</div>
						<div class="field half">
							<label><span>Técnico:</span> <strong><em>*</em></strong></label>
							<select class="obr" name="tecnico_id" nomecampo="Técnico">
								<option value=""></option>
								<?
								$oTec = new Tecnico();
								$aTec = $oTec->getAll();
								foreach ($aTec as $value) {
									$selected = $objClassePg->getTecnico()->id == $value->id ?
											'selected="selected"':'';
									echo "<option value='{$value->id}' $selected >{$value->nome}</option>";
								}
								?>
							</select>
						</div>
						<div class="field half">
							<label><span>Categoria:</span> <strong><em>*</em></strong></label>
							<select class="obr" name="categoria_id" nomecampo="Categoria">
								<option value=""></option>
								<?
								$oCat = new ChamadoCategoria();
								$aCat = $oCat->getAll();
								foreach ($aCat as $value) {
									$selected = $objClassePg->getCategoria()->id == $value->id ?
											'selected="selected"':'';
									echo "<option value='{$value->id}' $selected >{$value->nome}</option>";
								}
								?>
							</select>
						</div>
						<div class="field half">
							<label><span>SLA do chamado</span> <strong><em>*</em></strong><span class="contador">Em horas</span></label>
							<?php 
							$date1 = new \DateTime($objClassePg->dataabertura);
							$date2 = new \DateTime($objClassePg->prazoentrega);
							$diff = $date1->diff($date2);
							$horas = $diff->d ? $diff->d * 24 : 0;
							$horas += $diff->h;
							?>
							<input type="text" name="sla" class="obr number" value="<?=$horas?>" maxlength="3"/>
						</div>

						<div class="field full alto">
							<label><span>Descrição</span> <strong><em>*</em></strong> <span class="contador">1000</span></label>
							<textarea onkeyup="limita_texto(this, 1000)" class="obr"  name="descricao" nomecampo="Descrição"><?php echo $objClassePg->descricao; ?></textarea>
						</div>
						
						<div class="field full alto">
							<label ><span>Problema</span> <span class="contador">1000</span></label>
							<textarea onkeyup="limita_texto(this, 1000)" class=""  name="problema"><?php echo $objClassePg->problema; ?></textarea>
						</div>
						
						<div class="field half">
							<label ><span>Status</span> <strong><em>*</em></strong></label>
							<select name="status">
								<?
								$statusLabel = array('Fechado','Aberto','Aguardando');
								foreach ($statusLabel as $key =>$value) {
									$selected = $key == $objClassePg->status ?
											'selected="selected"' : '';
									
//									$selected = $objClassePg->status == '' && $key == 1 ?
//											'selected="selected"' : '';
									
									echo "<option value='{$key}' $selected >{$value}</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="field full controles">
						<a href="#" onclick="$('#form_ins').submit();return false;" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-disk"></span>Salvar</a>
						<a href="<?php echo $linkCancelar; ?>" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-closethick"></span>Cancelar</a>
						<input type="submit" class="submit" />
					</div>
				</form>
			</div>
		</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
