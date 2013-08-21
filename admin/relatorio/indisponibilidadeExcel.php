<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

require_once DIR_ROOT.'libs/Microsoft/PHPExcel/IOFactory.php';
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
	$objeto = new $classePagina();
	$filter = new Filter();
	$filter->orderBy('dataabertura DESC');
	$lista = $objeto->getRelatorioIndisponibilidade($filter);
}

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load(DIR_ROOT."docs/templaterelatorio.xls");
$objPHPExcel->getActiveSheet()->setCellValue('A14', date('m').'/'.date('Y'));
$baseRow = 11;
foreach ($lista as $r =>$itemLista) {
	$row = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $itemLista->id)
	                              ->setCellValue('B'.$row, date('d/m/Y H:i:s', strtotime($itemLista->dataabertura)))
	                              ->setCellValue('C'.$row, $itemLista->datafechamento ? date('d/m/Y H:i:s', strtotime($itemLista->datafechamento)) : 'Ainda fora')
	                              ->setCellValue('D'.$row, helpers\Date::intervalDiff($itemLista->dataabertura, $itemLista->datafechamento ? : 'now' ))
	                              ->setCellValue('E'.$row, $itemLista->descricao)
	                              ->setCellValue('F'.$row, $itemLista->pro_relatado)
	                              ->setCellValue('G'.$row, $itemLista->pro_encontrado)
	                              ->setCellValue('H'.$row, $itemLista->solucao)
	                              ->setCellValue('I'.$row, $itemLista->observacao);
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(DIR_ROOT.'/relatorios/'.date('Ymdhi').'RTG.xls');

?>