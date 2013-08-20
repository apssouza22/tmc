<?php
// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"relatorio".date('ymd').".xls\"" );
header ("Content-Description: PHP Generated Data" );

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
} else {
	exit;
}
?>
<table border="1">
	<caption>RTG - RELATÓRIO TÉCNICO GERENCIAL</caption>
	<thead>
		<tr style="background: #000; color: #fff;"  >
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
				<td><?php echo date('d/m/Y H:i:s', strtotime($itemLista->dataabertura)); ?></td>
				<td>
					<?= $itemLista->datafechamento ? date('d/m/Y H:i:s', strtotime($itemLista->datafechamento)) : 'Ainda fora'; ?>
				</td>
				<td>
					<?php echo helpers\Date::intervalDiff($itemLista->dataabertura, $itemLista->datafechamento ? : 'now' ); ?>
				</td>
				<td>
					<?= nl2br($itemLista->descricao) ?>
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