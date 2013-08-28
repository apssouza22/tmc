<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Manutencao';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar manutenção';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Nova manutenção';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new $classePagina($id);
$dataIni1 = explode(' ', $_POST['inicio']);
$dataIni = explode('/', $dataIni1[0]);

$dataFim1 = explode(' ', $_POST['fim']);
$dataFim = explode('/', $dataFim1[0]);
$dataIni = implode('-', array_reverse($dataIni)) . ' ' . $dataIni1[1];
$dataFim = implode('-', array_reverse($dataFim)) . ' ' . $dataFim1[1];

//var_dump($dataFim);EXIT;

$_POST['inicio'] = $dataIni;
$_POST['fim'] = $dataFim;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
						<h3>Dados da manutenção</h3>
						
						
						<div class="field alto fck full">
							<label><span>Descrição:</span> <strong><em>*</em></strong></label>
							<?php Fck::write('descricao', htmlspecialchars_decode($objClassePg->descricao)); ?>
						</div>
						
						<? // if(isset($_REQUEST['id'])){?>
							<div class="field alto fck full">
								<label><span>Observações:</span></label>
								<?php Fck::write('observacao', htmlspecialchars_decode($objClassePg->observacao)); ?>
							</div>
						<? //}?>
						
						<div class="field  half">
							<label><span>Início:</span></label>
							<input type="text" class="datetimepicker " value="<?=$objClassePg->inicio? date('d/m/Y H:i',strtotime($objClassePg->inicio)) : ''?>" name="inicio"></input>
						</div>
						
						<div class="field half">
							<label><span>Fim:</span></label>
							<input type="text" value="<?= $objClassePg->fim ? date('d/m/Y H:i',strtotime($objClassePg->fim)) : ''?>" class="datetimepicker " name="fim"></input>
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
