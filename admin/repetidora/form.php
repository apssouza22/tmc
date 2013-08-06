<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Repetidora';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar Repetidora';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Nova Repetidora';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new $classePagina($id);

if ($_POST) {
	if($_POST['cliente_id']){
		$equip = new Equipamento();
		$idEquip = $equip->insert(array(
			'cliente_id' =>$_POST['cliente_id'],
			'descricao' => $_POST['descricao'],
			'ip' => $_POST['ip']
		));
	}
	$_POST['cliente_id']	= null;
	$_POST['descricao']		= null;
	$_POST['ip'] = null;
	$_POST['equipamento_id'] = $idEquip?: 0;
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
							<label><span>Nome:</span> <strong><em>*</em></strong></label>
							<input type="text" name="nome" class="obr" value="<?= $objClassePg->nome ?>"></input>
						</div>

						<div class="field">
							<label><span>Nome do condominio:</span></label>
							<input type="text" name="nome_condominio" value="<?= $objClassePg->nome_condominio ?>"></input>
						</div>

						<div class="field">
							<label><span>Nome do síndico:</span></label>
							<input type="text" name="nome_sindico" value="<?= $objClassePg->nome_sindico ?>"></input>
						</div>

						<div class="field half">
							<label><span>Telefone do síndico:</span></label>
							<input type="text" name="telefone_sindico" value="<?= $objClassePg->telefone_sindico ?>"></input>
						</div>

						<div class="field">
							<label><span>Nome da administradora:</span></label>
							<input type="text" name="nome_administradora" value="<?= $objClassePg->nome_administradora ?>"></input>
						</div>

						<div class="field half">
							<label><span>Telefone da administradora:</span></label>
							<input type="text" name="telefone_administradora" value="<?= $objClassePg->telefone_administradora ?>"></input>
						</div>

						<div class="field">
							<label><span>Nome do zelador:</span></label>
							<input type="text" name="nome_zelador" value="<?= $objClassePg->nome_zelador ?>"></input>
						</div>

						<div class="field half">
							<label><span>Telefone do zelador:</span></label>
							<input type="text" name="telefone_zelador" value="<?= $objClassePg->telefone_zelador ?>"></input>
						</div>

						<div class="field ">
							<label><span>Endereco:</span><strong><em>*</em></strong></label>
							<input type="text" name="endereco" class="obr" value="<?= $objClassePg->endereco ?>"></input>
						</div>

						<div class="field half">
							<label><span>Cep:</span> <strong><em>*</em></strong></label>
							<input type="text" name="cep" class="obr" value="<?= $objClassePg->cep ?>"></input>
						</div>
						<div class="field half">
							<label><span>Cidade:</span> <strong><em>*</em></strong></label>
							<input type="text" name="cidade" class="obr" value="<?= $objClassePg->cidade ?>"></input>
						</div>

						<div class="field half">
							<label><span>Estado:</span> <strong><em>*</em></strong></label>
							<select name="estado" id="estado" class="obr">
								<option value=""></option>
								<?			
								$estados = array('AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','SC','SE','SP','TO');
								foreach ($estados as $value) 
								{	
									$selected = $value== $objClassePg->estado ? 'selected="selected"': '';
									echo "<option value='$value' $selected>$value</option>";
								}?>
							</select>
						</div>

					</div>
					
					<div class="caixa">
						<h3>Dados do sentinela</h3>
						<div class="field">
							<label><span>Cliente:</span> </label>
							<select name="cliente_id" nomecampo="Cliente">
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
							<label><span>Ip:</span></label>
							<input type="text" name="ip" value="<?=$objClassePg->ip?> " placeholder="192.168.111.111" ></input>
						</div>
						
						<div class="field">
							<label><span>Descrição:</span></label>
							<input type="text" name="descricao" value="<?=$objClassePg->descricao?>" maxlength="255"></input>
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
