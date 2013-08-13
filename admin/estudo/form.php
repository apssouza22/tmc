<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();

$classePagina = 'Estudo';

if ($_REQUEST['id']) {
	$id = $_REQUEST['id'];
	$tituloPagina = 'Editar estudo';
	$linkCancelar = constant("{$classePagina}::PG_DETALHE") . '?id=' . $id;
} else {
	$id = null;
	$tituloPagina = 'Novo estudo';
	$linkCancelar = constant("{$classePagina}::PG_LISTAR");
}

$objClassePg = new $classePagina($id);
$oChamado = $objClassePg->getChamado();

if ($_POST) {
	$dateTime = new DateTime();
	$dateInterval = new DateInterval('P0D');
	$dateInterval->h =$_POST['sla'];
	$prazoentrega = $dateTime->add($dateInterval )->format('Y-m-d H:i:s');
	$_POST['sla'] = null;
	
	$chamado = new Chamado();
	$idchamado = $chamado->store(array(
		'descricao' => ' ',
		'prazoentrega' => $prazoentrega,
		'status' => 1,
		'cliente_id' => $_POST['cliente_id'],
		'id' => $_POST['chamado_id']
	));
	
	$idchamado = empty($_POST['chamado_id']) ? $idchamado : $_POST['chamado_id'];
	$id = $objClassePg->store(array(
		'chamado_id' => $idchamado,
		'texto' => $_POST['texto'],
		'titulo' => $_POST['titulo'],
		'observacao' => $_POST['observacao'],		
		'datacadastro' => date('Y-m-d h:i:s'),
		'id' => $_POST['id']
	));
	
	$chamado->update(array(
		'descricao'=> 'Estudo de viabilidade, mais informação <a href="'.DIR_CMS_HTM_ROOT.'estudo/detalhes.php?id='.$id.'">aqui</a>'
		), $idchamado);
	
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
					<input type="hidden" name="chamado_id" value="<?php echo $objClassePg->chamado_id; ?>" />

					<div class="caixa">
						<h3>Dados do estudo</h3>
						<div class="field ">
							<label><span>Cliente:</span> <strong><em>*</em></strong></label>
							<select class="obr" name="cliente_id" nomecampo="Cliente">
								<option value=""></option>
								<?
								$oCliente = new Cliente();
								$aClientes = $oCliente->getAll();
								foreach ($aClientes as $value) {
									$selected = $oChamado->getCliente()->id == $value->id ?
											'selected="selected"':'';
									echo "<option value='{$value->id}' $selected >{$value->empresa}</option>";
								}
								?>
							</select>
						</div>
						
						<div class="field half">
							<label><span>Tempo para execução</span> <strong><em>*</em></strong><span class="contador">Em horas</span></label>
							<?php 
							$date1 = new \DateTime($oChamado->dataabertura);
							$date2 = new \DateTime($oChamado->prazoentrega);
							$diff = $date1->diff($date2);
							$horas = $diff->d ? $diff->d * 24 : 0;
							$horas += $diff->h;
							?>
							<input type="text" name="sla" class="obr number" value="<?=$horas?>" maxlength="3"/>
						</div>
						<div class="field ">
							<label><span>Titulo</span> <strong><em>*</em></strong></label>
							<input type="text" name="titulo" class="obr " value="<?=$objClassePg->titulo ?>" />
						</div>

						<div class="field alto full">
							<label><span>Descrição:</span> <strong><em>*</em></strong></label>
							<textarea name="texto" ><?=$objClassePg->texto ?></textarea>
						</div>
						
						<? if(isset($_REQUEST['id'])){?>
							<div class="field alto full">
								<label><span>Resposta:</span></label>
								<textarea name="observacao" rows="20"><?=$objClassePg->observacao ?></textarea>
							</div>
						<? }?>
						
						
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
