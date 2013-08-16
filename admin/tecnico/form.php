<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Tecnico';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar T�cnico';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Novo T�cnico';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new $classePagina($id);

if ($_POST) {
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

				<h1><?php echo $tituloPagina; ?> <span class="botoes"><em>*</em> Campos obrigat�rios</span></h1>

				<?php Utils::escreve_alerta(); ?>


				<form method="post" name="form_ins" id="form_ins" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return checar(this)">
					<input type="hidden" name="id" value="<?php echo $id; ?>" />

					<div class="caixa">
						<h3>Dados</h3>
						<div class="field">
							<label><span>Nome:</span> <strong><em>*</em></strong></label>
							<input type="text" class="obr" name="nome" value="<?= $objClassePg->nome ?>"></input>
						</div>
						<div class="field">
							<label><span>Email:</span> <strong><em>*</em></strong></label>
							<input type="text" class="obr" name="email" value="<?= $objClassePg->email ?>"></input>
						</div>
						
						<div class="field">
							<label><span>Telefone:</span> <strong><em>*</em></strong></label>
							<input type="text" class="obr" name="telefone" value="<?= $objClassePg->telefone?>"></input>
						</div>
						<div class="field">
							<label><span>RG:</span></label>
							<input type="text"  name="rg" value="<?= $objClassePg->rg?>"></input>
						</div>
					</div>
						
						
				</form>
					<div class="field full controles">
						<a href="#" onclick="$('#form_ins').submit();
						return false;" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-disk"></span>Salvar</a>
						<a href="<?php echo $linkCancelar; ?>" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-closethick"></span>Cancelar</a>
						<input type="submit" class="submit" />
					</div>
			</div>
		</div>
		<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>

		
		<script src="<?php echo DIR_CMS_HTM_ROOT; ?>js/admin.js?versao=1" type="text/javascript"></script>
	</body>
</html>
