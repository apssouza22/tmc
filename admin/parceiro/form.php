<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Cliente';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar Cliente';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Novo Cliente';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new $classePagina($id);

if ($_POST) {
	$objClassePg->store($_POST);
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
						<div class="field">
							<label><span>Nome do cliente:</span> <strong><em>*</em></strong></label>
							<input type="text" name="empresa" value="<?= $objClassePg->empresa ?>"></input>
						</div>

						<div class="field">
							<label><span>Nome do responsável:</span> <strong><em>*</em></strong></label>
							<input type="text" name="nome_responsavel" value="<?= $objClassePg->nome_responsavel ?>"></input>
						</div>

						<div class="field">
							<label><span>Email:</span> <strong><em>*</em></strong></label>
							<input type="text" name="email" value="<?= $objClassePg->email ?>"></input>
						</div>

						<div class="field half">
							<label><span>Telefone:</span> <strong><em>*</em></strong></label>
							<input type="text" name="telefone" value="<?= $objClassePg->telefone ?>"></input>
						</div>
						<div class="field half">
							<label><span>Telefone 2:</span> <strong><em>*</em></strong></label>
							<input type="text" name="telefone1" value="<?= $objClassePg->telefone1 ?>"></input>
						</div>
						<div class="field half">
							<label><span>Telefone 3:</span> <strong><em>*</em></strong></label>
							<input type="text" name="telefone2" value="<?= $objClassePg->telefone2 ?>"></input>
						</div>

						<div class="field half">
							<label><span>Cep:</span> <strong><em>*</em></strong></label>
							<input type="text" name="cep" maxlength="9" value="<?= $objClassePg->cep ?>"></input>
						</div>

						<div class="field">
							<label><span>Endereço:</span> <strong><em>*</em></strong></label>
							<input type="text" name="endereco" value="<?= $objClassePg->endereco ?>"></input>
						</div>

						<div class="field half">
							<label><span>Bairro:</span> <strong><em>*</em></strong></label>
							<input type="text" name="bairro" value="<?= $objClassePg->bairro ?>"></input>
						</div>

						<div class="field ">
							<label><span>Cidade:</span> <strong><em>*</em></strong></label>
							<input type="text" name="cidade" value="<?= $objClassePg->cidade ?>"></input>
						</div>
						<div class="field half">
							<label><span>Estado:</span> <strong><em>*</em></strong></label>
							<input type="text" name="estado" maxlength="2" value="<?= $objClassePg->estado ?>"></input>
						</div>
						<div class="field half">
							<label><span>Serviço:</span> <strong><em>*</em></strong></label>
							<select name="servico_nome[]">
								<option value="Lan-to-lan">Lan-to-lan</option>
								<option value="Porta ip">Porta ip</option>
							</select>
						</div>
						<div class="field half">
							<label><span>Velocidade:</span> <strong><em>*</em></strong></label>
							<input type="text" name="servico_velocidade[]" maxlength="2" value="<?= $objClassePg->estado ?>"></input>
						</div>

					</div>
					<div class="field full controles">
							<a href="#" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-disk"></span>Nova unidade</a>
						</div>
					<div class="caixa">
						<h3>Dados da unidade</h3>

						<div class="field">
							<label><span>Nome do responsável:</span> <strong><em>*</em></strong></label>
							<input type="text" name="nome_responsavel" value="<?= $objClassePg->nome_responsavel ?>"></input>
						</div>

						<div class="field">
							<label><span>Email:</span> <strong><em>*</em></strong></label>
							<input type="text" name="email" value="<?= $objClassePg->email ?>"></input>
						</div>

						<div class="field half">
							<label><span>Telefone:</span> <strong><em>*</em></strong></label>
							<input type="text" name="telefone" value="<?= $objClassePg->telefone ?>"></input>
						</div>
						<div class="field half">
							<label><span>Telefone 2:</span> <strong><em>*</em></strong></label>
							<input type="text" name="telefone1" value="<?= $objClassePg->telefone1 ?>"></input>
						</div>
						<div class="field half">
							<label><span>Telefone 3:</span> <strong><em>*</em></strong></label>
							<input type="text" name="telefone2" value="<?= $objClassePg->telefone2 ?>"></input>
						</div>

						<div class="field half">
							<label><span>Cep:</span> <strong><em>*</em></strong></label>
							<input type="text" name="cep" maxlength="9" value="<?= $objClassePg->cep ?>"></input>
						</div>

						<div class="field">
							<label><span>Endereço:</span> <strong><em>*</em></strong></label>
							<input type="text" name="endereco" value="<?= $objClassePg->endereco ?>"></input>
						</div>

						<div class="field half">
							<label><span>Bairro:</span> <strong><em>*</em></strong></label>
							<input type="text" name="bairro" value="<?= $objClassePg->bairro ?>"></input>
						</div>

						<div class="field half">
							<label><span>Cidade:</span> <strong><em>*</em></strong></label>
							<input type="text" name="cidade" value="<?= $objClassePg->cidade ?>"></input>
						</div>
						<div class="field half">
							<label><span>Estado:</span> <strong><em>*</em></strong></label>
							<input type="text" name="estado" maxlength="2" value="<?= $objClassePg->estado ?>"></input>
						</div>
						<div class="field half">
							<label><span>Serviço:</span> <strong><em>*</em></strong></label>
							<select name="servico_nome[]">
								<option value="Lan-to-lan">Lan-to-lan</option>
								<option value="Porta ip">Porta ip</option>
							</select>
						</div>
						<div class="field half">
							<label><span>Velocidade:</span> <strong><em>*</em></strong></label>
							<input type="text" name="servico_velocidade[]" maxlength="2" value="<?= $objClassePg->estado ?>"></input>
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
