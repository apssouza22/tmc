<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Queda';
if (!$_POST) {
	$objeto = new $classePagina();
	$filter = new Filter();
	$filter->orderBy('datainicio DESC');
	$filter->where($sqlWhere);
	$lista = $objeto->getAllCompleto($filter);
} else {
	$_POST['inicio'] = $_POST['inicio'] ? : '01/01/2000 00:00:00';

	$dataIni = explode(' ', $_POST['inicio']);
	$dataIni = explode('/', $dataIni[0]);
	$dataFim = explode(' ', $_POST['fim']);
	$dataFim = explode('/', $dataFim[0]);
	$dataIni = implode('-', array_reverse($dataIni)) . ' 00:00:00';
	$dataFim = implode('-', array_reverse($dataFim)) . ' 23:59:59';
	$objeto = new $classePagina();
	$filter = new Filter();
	$filter->orderBy('datainicio DESC');
	$filter->where("datainicio BETWEEN '{$dataIni}' AND  '{$dataFim}'");
	$lista = $objeto->getAllCompleto($filter, $_POST['cliente']);
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
				<form method="post" name="form_ins" id="form_ins" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return checar(this)">
					<div class="caixa">
						<h3>Filtrar</h3>
						<div class="field half">
							<label><span>Cliente:</span> <strong><em>*</em></strong></label>
							<select class="" name="cliente" nomecampo="Cliente">
								<option value="">Todos</option>
								<?
								$oCliente = new Cliente();
								$aClientes = $oCliente->getAll();
								foreach ($aClientes as $value) {
									$selected = $_POST['cliente'] == $value->id ? 'selected="selected"' : '';
									echo "<option value='{$value->id}' $selected >{$value->empresa}</option>";
								}
								?>
							</select>

						</div>
						<div class="field  half">
							<label><span>Início:</span></label>
							<input type="text" class="datetimepicker " value="<?= $_POST['inicio'] ?>" name="inicio"></input>
						</div>
						<div class="field half">
							<label><span>Fim:</span></label>
							<input type="text" value="<?= isset($_POST['fim']) ? $_POST['fim'] : date('d/m/Y') ?>" class="datetimepicker " name="fim"></input>
						</div>


					</div>
					<div class="field full controles">
						<a href="#" onclick="$('#form_ins').submit();
						return false;" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-disk"></span>Salvar</a>
						<a href="<?php echo $linkCancelar; ?>" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-closethick"></span>Cancelar</a>
						<input type="submit" class="submit" />
					</div>
				</form>
				<div class="caixa">
				<!--<h1><strong>Lista de quedas</strong></h1>-->
				<h3>Relatório</h3>

				<?php
				if (!$lista) {
					?>
					<p>Nenhum item encontrado.</p>
					<?php
				} else {
					?>
					<table class="tb_dados_desc">
						<thead>
							<tr>
								<th>Data de inicio</th>
								<th>Data da volta</th>
								<th>Período fora</th>
								<th>Equipamento</th>
								<th>Motivo</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($lista as $itemLista) {
								$classe_visibilidade = $itemLista->status == 1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
								$bt_view = '<a href="detalhes.php?id=' . $itemLista->id . '" class="bt_ico ico_view" title="detalhes"><em>detalhes</em></a>';
								$bt_action = $bt_view . $bt_edit;
								?>
								<tr>
									<td class="quando"><em><?php echo $itemLista->datainicio; ?></em> <?php echo date('d/m/Y H:i:s', strtotime($itemLista->datainicio)); ?></td>
									<td>
										<?= $itemLista->datafim ? date('d/m/Y H:i:s', strtotime($itemLista->datafim)) : 'Ainda fora'; ?>
									</td>
									<td>
										<?php echo helpers\Date::intervalDiff($itemLista->datainicio, $itemLista->datafim ? : 'now' ); ?>
									</td>
									<td>
										<?= $itemLista->descricao ?>
									</td>
									<td>
										<?= $itemLista->problema == 'NULL' ? 'Não informado' : $itemLista->problema ?>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
					<?php
				}
				?>

				</div>
			</div>
		</div>
		<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
