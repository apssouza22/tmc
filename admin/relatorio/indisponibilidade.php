<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Relatorio';
if ($_POST) {
	$_POST['inicio'] = $_POST['inicio'] ? : '01/01/2000 00:00:00';

	$dataIni = explode(' ', $_POST['inicio']);
	$dataIni = explode('/', $dataIni[0]);
	$dataFim = explode(' ', $_POST['fim']);
	$dataFim = explode('/', $dataFim[0]);
	$dataIni = implode('-', array_reverse($dataIni)) . ' 00:00:00';
	$dataFim = implode('-', array_reverse($dataFim)) . ' 23:59:59';
	$objeto = new $classePagina();
	$filter = new Filter();
	$filter->orderBy('dataabertura DESC');
	$filter->where("datainicio BETWEEN '{$dataIni}' AND  '{$dataFim}'");
	$lista = $objeto->getRelatorioIndisponibilidade($filter, $_POST['cliente']);
}else{
	$objeto = new $classePagina();
	$filter = new Filter();
	$filter->orderBy('dataabertura DESC');
	$lista = $objeto->getRelatorioIndisponibilidade($filter);
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
						<a href="#"  onclick="$('#form_ins').submit();
						return false;" class="bt_padrao ui-state-default ui-corner-all"><span style="background-position: -162px -112px;" class="ui-icon ui-icon-disk"></span>Buscar</a>
						<a href="#" onclick="exportarRelatorioIndisponibilidade(); return false;" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon  ui-icon-disk"></span>Exportar</a>
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
								<th>Nº Chamado </th>
								<th>Data de inicio</th>
								<th>Data da volta</th>
								<th>Duração</th>
								<th>Site</th>
								<th>Problema relatado</th>
								<th>Problema encontrado</th>
								<th>Solução</th>
								<th>Observação</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($lista as $itemLista) {
								?>
								<tr>
									<td>
										<?= $itemLista->id; ?>
									</td>
									<td class="quando"><em><?php echo $itemLista->dataabertura; ?></em> <?php echo date('d/m/Y H:i:s', strtotime($itemLista->dataabertura)); ?></td>
									<td>
										<?= $itemLista->datafechamento ? date('d/m/Y H:i:s', strtotime($itemLista->datafechamento)) : 'Ainda fora'; ?>
									</td>
									<td>
										<?php echo helpers\Date::intervalDiff($itemLista->dataabertura, $itemLista->datafechamento ?: 'now' );?>
									</td>
									<td>
										<?= nl2br($itemLista->nome) ?>
									</td>
									<td>
										<?= nl2br($itemLista->pro_relatado) ?>
									</td>
									<td>
										<?= nl2br($itemLista->pro_encontrado) ?>
									</td>
									<td>
										<?= nl2br($itemLista->solucao) ?>
									</td>
									<td>
										<?= nl2br($itemLista->observacao) ?>
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
		<script src="<?php echo DIR_CMS_HTM_ROOT; ?>js/admin.js?versao=1" type="text/javascript"></script>
	</body>
</html>
