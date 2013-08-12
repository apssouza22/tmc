<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Cliente';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar cliente';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Novo cliente';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new Cliente($id);

if ($_POST) {
	$id = $objClassePg->store(array(
		'empresa' => $_POST['empresa'],
		'nome_gerente' => $_POST['nome_gerente'],
		'email' => $_POST['email'],
		'telefone' => $_POST['telefone'],
		'id' => $_POST['id']
	));


	$oUnidade = new ClienteUnidade();
	if (isset($_POST['nome_responsavel'])) {
		foreach ($_POST['nome_responsavel'] as $key => $value) {
			if(!empty($_POST['nome'][$key])){
				$oUnidade->store(array(
					'cliente_id' => $id,
					'nome' => $_POST['nome'][$key],
					'nome_responsavel' => $_POST['nome_responsavel'][$key],
					'email' => $_POST['uni_email'][$key],
					'nome' => $_POST['nome'][$key],
					'telefone' => $_POST['uni_telefone'][$key],
					'telefone1' => $_POST['telefone1'][$key],
					'telefone2' => $_POST['telefone2'][$key],
					'endereco' => $_POST['endereco'][$key],
					'cep' => $_POST['cep'][$key],
					'bairro' => $_POST['bairro'][$key],
					'cidade' => $_POST['cidade'][$key],
					'estado' => $_POST['estado'][$key],
					'ismatriz' => isset($_POST['ismatriz_' . $key]) ? $_POST['ismatriz_' . $key] : 0,
					'velocidadelan' => $_POST['velocidadelan'][$key],
					'velocidadeip' => $_POST['velocidadeip'][$key],
					'parceiro_id' => $_POST['parceiro_id'][$key],
				));
			}
		}
	}


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
							<label><span>Nome da empresa:</span> <strong><em>*</em></strong></label>
							<input type="text" name="empresa" value="<?= $objClassePg->empresa ?>"></input>
						</div>
						<div class="field">
							<label><span>Nome do gerente/responsável:</span> <strong><em>*</em></strong></label>
							<input type="text" name="nome_gerente" value="<?= $objClassePg->nome_gerente ?>"></input>
						</div>

						<div class="field">
							<label><span>Email:</span> <strong><em>*</em></strong></label>
							<input type="text" name="email" value="<?= $objClassePg->email ?>"></input>
						</div>
						<div class="field">
							<label><span>Telefone:</span> <strong><em>*</em></strong></label>
							<input type="text" name="telefone" maxlength="45" value="<?= $objClassePg->telefone ?>"></input>
						</div>
					</div>
					<?
					$indice = 0;
					if (!isset($_REQUEST['id'])) {
						?>
						<div class="caixa " >
							<h3>Dados</h3>

							<div class="field">
								<label><span>Nome da unidade:</span> <strong><em>*</em></strong></label>
								<input type="text" name="nome[]" ></input>
							</div>
							<div class="field">
								<label><span>Nome do responsável:</span> <strong><em>*</em></strong></label>
								<input type="text" name="nome_responsavel[]" ></input>
							</div>

							<div class="field">
								<label><span>Email:</span> <strong><em>*</em></strong></label>
								<input type="text" name="uni_email[]" ></input>
							</div>

							<div class="field half">
								<label><span>Telefone:</span> <strong><em>*</em></strong></label>
								<input type="text" name="uni_telefone[]" maxlength="45" ></input>
							</div>
							<div class="field half">
								<label><span>Telefone 2:</span> <strong><em>*</em></strong></label>
								<input type="text" name="telefone1[]" maxlength="45" ></input>
							</div>
							<div class="field half">
								<label><span>Telefone 3:</span> <strong><em>*</em></strong></label>
								<input type="text" name="telefone2[]" maxlength="45" ></input>
							</div>

							<div class="field half">
								<label><span>Cep:</span> <strong><em>*</em></strong></label>
								<input type="text" name="cep[]" maxlength="9" ></input>
							</div>

							<div class="field">
								<label><span>Endereço:</span> <strong><em>*</em></strong></label>
								<input type="text" name="endereco[]" ></input>
							</div>

							<div class="field half">
								<label><span>Bairro:</span> <strong><em>*</em></strong></label>
								<input type="text" name="bairro[]" ></input>
							</div>

							<div class="field ">
								<label><span>Cidade:</span> <strong><em>*</em></strong></label>
								<input type="text" name="cidade[]" ></input>
							</div>
							<div class="field half">
								<label><span>Estado:</span> <strong><em>*</em></strong></label>
								<input type="text" name="estado[]" maxlength="2" ></input>
							</div>
							<div class="field half">
								<label><span>Velocidade Lan-to-lan:</span> <strong><em>*</em></strong></label>
								<input type="text" name="velocidadelan[]" maxlength="50" ></input>
							</div>
							<div class="field half">
								<label><span>Velocidade porta IP:</span> <strong><em>*</em></strong></label>
								<input type="text" name="velocidadeip[]" maxlength="50" ></input>
							</div>
							<div class="field half">
								<label><span>Matriz? :</span> <strong><em>*</em></strong></label>

								<input type="checkbox" name="ismatriz_<?= $indice++ ?>" value="1" > ></input>
							</div>

							<div class="field half">
								<label><span>Parceiro:</span> </label>
								<select name="parceiro_id">
									<option></option>';
									<?
									$parceiro = new Parceiro();
									$parceiros = $parceiro->getAllVisible();
									foreach ($parceiros as $value) {
										echo "<option  value='{$value->id}'> " . $value->nome . '</option>';
									}
									?>
								</select>
							</div>

						</div>

						<?
					}
						$unidades = $objClassePg->getAllUnidades();

						foreach ($unidades as $oUnidade) {
							?>

							<div class="caixa " >
								<h3>Dados</h3>

								<div class="field">
									<label><span>Nome da unidade:</span> <strong><em>*</em></strong></label>
									<input type="text" name="nome[]" value="<?= $oUnidade->nome ?>"></input>
								</div>
								<div class="field">
									<label><span>Nome do responsável:</span> <strong><em>*</em></strong></label>
									<input type="text" name="nome_responsavel[]" value="<?= $oUnidade->nome_responsavel ?>"></input>
								</div>

								<div class="field">
									<label><span>Email:</span> <strong><em>*</em></strong></label>
									<input type="text" name="uni_email[]" value="<?= $oUnidade->email ?>"></input>
								</div>

								<div class="field half">
									<label><span>Telefone:</span> <strong><em>*</em></strong></label>
									<input type="text" name="uni_telefone[]" maxlength="45" value="<?= $oUnidade->telefone ?>"></input>
								</div>
								<div class="field half">
									<label><span>Telefone 2:</span> <strong><em>*</em></strong></label>
									<input type="text" name="telefone1[]" maxlength="45" value="<?= $oUnidade->telefone1 ?>"></input>
								</div>
								<div class="field half">
									<label><span>Telefone 3:</span> <strong><em>*</em></strong></label>
									<input type="text" name="telefone2[]" maxlength="45" value="<?= $oUnidade->telefone2 ?>"></input>
								</div>

								<div class="field half">
									<label><span>Cep:</span> <strong><em>*</em></strong></label>
									<input type="text" name="cep[]" maxlength="9" value="<?= $oUnidade->cep ?>"></input>
								</div>

								<div class="field">
									<label><span>Endereço:</span> <strong><em>*</em></strong></label>
									<input type="text" name="endereco[]" value="<?= $oUnidade->endereco ?>"></input>
								</div>

								<div class="field half">
									<label><span>Bairro:</span> <strong><em>*</em></strong></label>
									<input type="text" name="bairro[]" value="<?= $oUnidade->bairro ?>"></input>
								</div>

								<div class="field ">
									<label><span>Cidade:</span> <strong><em>*</em></strong></label>
									<input type="text" name="cidade[]" value="<?= $oUnidade->cidade ?>"></input>
								</div>
								<div class="field half">
									<label><span>Estado:</span> <strong><em>*</em></strong></label>
									<input type="text" name="estado[]" maxlength="2" value="<?= $oUnidade->estado ?>"></input>
								</div>
								<div class="field half">
									<label><span>Velocidade Lan-to-lan:</span> <strong><em>*</em></strong></label>
									<input type="text" name="velocidadelan[]" maxlength="50" value="<?= $oUnidade->velocidadelan ?>"></input>
								</div>
								<div class="field half">
									<label><span>Velocidade porta IP:</span> <strong><em>*</em></strong></label>
									<input type="text" name="velocidadeip[]" maxlength="50" value="<?= $oUnidade->velocidadeip ?>"></input>
								</div>
								<div class="field half">
									<label><span>Matriz? :</span> <strong><em>*</em></strong></label>
									<?
									$checked = '';
									if ($oUnidade->ismatriz == 1) {
										$checked = 'checked="checked"';
									}
									?>
									<input type="checkbox" name="ismatriz_<?= $indice++ ?>" value="1" <?= $checked ?> ></input>
								</div>

								<div class="field half">
									<label><span>Parceiro:</span> </label>
									<select name="parceiro_id">
										<option></option>';
										<?
										$parceiro = new Parceiro();
										$parceiros = $parceiro->getAllVisible();
										foreach ($parceiros as $value) {
											$selected = '';
											if ($value->id == $oUnidade->parceiro_id) {
												$selected = 'selected="selected"';
											}
											echo "<option $selected value='{$value->id}'> " . $value->nome . '</option>';
										}
										?>
									</select>
								</div>

							</div>
						<? } ?>

						<div class="field full controles">
							<a  class="bt_padrao ui-state-default ui-corner-all js-addNovaUnidade"><span class="ui-icon ui-icon-disk"></span>Nova unidade</a>
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

			<div class="modelo unidade" style="display: none;">
				<div class="caixa " >
					<h3>Dados</h3>

					<div class="field">
						<label><span>Nome da unidade:</span> <strong><em>*</em></strong></label>
						<input type="text" name="nome[]" ></input>
					</div>
					<div class="field">
						<label><span>Nome do responsável:</span> <strong><em>*</em></strong></label>
						<input type="text" name="nome_responsavel[]" ></input>
					</div>

					<div class="field">
						<label><span>Email:</span> <strong><em>*</em></strong></label>
						<input type="text" name="email[]" ></input>
					</div>

					<div class="field half">
						<label><span>Telefone:</span> <strong><em>*</em></strong></label>
						<input type="text" name="telefone[]" maxlength="45" ></input>
					</div>
					<div class="field half">
						<label><span>Telefone 2:</span> <strong><em>*</em></strong></label>
						<input type="text" name="telefone1[]" maxlength="45" ></input>
					</div>
					<div class="field half">
						<label><span>Telefone 3:</span> <strong><em>*</em></strong></label>
						<input type="text" name="telefone2[]" maxlength="45"></input>
					</div>

					<div class="field half">
						<label><span>Cep:</span> <strong><em>*</em></strong></label>
						<input type="text" name="cep[]" maxlength="9" ></input>
					</div>

					<div class="field">
						<label><span>Endereço:</span> <strong><em>*</em></strong></label>
						<input type="text" name="endereco[]" ></input>
					</div>

					<div class="field half">
						<label><span>Bairro:</span> <strong><em>*</em></strong></label>
						<input type="text" name="bairro[]" ></input>
					</div>

					<div class="field ">
						<label><span>Cidade:</span> <strong><em>*</em></strong></label>
						<input type="text" name="cidade[]" ></input>
					</div>
					<div class="field half">
						<label><span>Estado:</span> <strong><em>*</em></strong></label>
						<input type="text" name="estado[]" maxlength="2" ></input>
					</div>
					<div class="field half">
						<label><span>Velocidade Lan-to-lan:</span> <strong><em>*</em></strong></label>
						<input type="text" name="velocidadelan[]" maxlength="50" ></input>
					</div>
					<div class="field half">
						<label><span>Velocidade porta IP:</span> <strong><em>*</em></strong></label>
						<input type="text" name="velocidadeip[]" maxlength="50" ></input>
					</div>
					<div class="field half">
						<label><span>Matriz?:</span> <strong><em>*</em></strong></label>
						<input type="checkbox" name="" class='matriz' value="1" ></input>
					</div>

					<div class="field half">
						<label><span>Parceiro:</span> </label>
						<select name="parceiro_id">
							<option></option>';
							<?
							$parceiro = new Parceiro();
							$parceiros = $parceiro->getAllVisible();
							foreach ($parceiros as $value) {
								echo "<option  value='{$value->id}'> " . $value->nome . '</option>';
							}
							?>
						</select>
					</div>

				</div>
				<div class="field full controles">
					<a  class="bt_padrao ui-state-default ui-corner-all js-addNovaUnidade"><span class="ui-icon ui-icon-disk"></span>Nova unidade</a>
				</div>
			</div>
		<script>
			var totalUnidades = '<?=$indice?>';
		</script>
			<script src="<?php echo DIR_CMS_HTM_ROOT; ?>js/admin.js?versao=1" type="text/javascript"></script>
	</body>
</html>
