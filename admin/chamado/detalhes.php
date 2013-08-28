<?php
include('../inc/inc_start.php');
require_once dirname(__FILE__) . '/../../include/config.php';
ContainerDi::getObject('UsuarioCMS')->autentica();


$classePagina = 'Chamado';

$objClassePg = new $classePagina($_GET['id']);

if (!$objClassePg->id) {
	header('Location: ' . constant("{$classePagina}::PG_LISTAR"));
	exit;
}
$cliente = $objClassePg->getCliente();
$unidade = $objClassePg->getUnidade();
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
				<?
				$classe_visibilidade = $objClassePg->status == 1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
				$bt_olho = '<a href="'.DIR_HTM_ROOT.'ajax.php" onclick="return toggle_exibir(\''.$classePagina.'\', ' . $objClassePg->id . ', this)" class="bt_ico ico_olho ' . $classe_visibilidade . '" title="status"><em>visibilidade</em></a>';
				$bt_view = '<a href="'.  constant("{$classePagina}::PG_LISTAR") . '" class="bt_ico ico_list" title="detalhes"><em>detalhes</em></a>';
				$bt_edit = '<a href="chamado.php?id=' . $objClassePg->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';
				$bt_olho = $objClassePg->status == 2 ? $bt_edit : $bt_olho ;
				$bt_action = $bt_olho . $bt_view . $bt_edit;
				?>

				<h1>Detalhes do chamado<span class="botoes"><?php echo $bt_action; ?></span></h1>


				<div class="caixa">
					<h3>Dados do chamado</h3>

					<div class="field ">
						<label><span>Empresa:</span></label>
						<?php echo $cliente->empresa; ?>
					</div>

					<div class="field ">
						<label><span>Unidade:</span></label>
						<?php echo $unidade->nome; ?>
					</div>

					<div class="field half">
						<label><span>Prazo:</span></label>
						<?php echo date('d/m/Y H:i:s', strtotime($objClassePg->prazoentrega)); ?>
					</div>

					<div class="field half ">
						<label><span>Categoria:</span></label>
						<?php echo $objClassePg->getCategoria()->nome; ?>
					</div>
					
					<div class="field alto">
						<label for="descricao"><span>Problema relatado:</span></label>
						<?php echo nl2br(htmlspecialchars_decode($objClassePg->pro_relatado)); ?>
					</div>
					
					<div class="field alto">
						<label for="descricao"><span>Problema encontrado:</span></label>
						<?php echo nl2br($objClassePg->pro_encontrado); ?>
					</div>
					
					<div class="field alto">
						<label for="descricao"><span>Solução:</span></label>
						<?php echo nl2br($objClassePg->solucao); ?>
					</div>
					
					<div class="field alto">
						<label for="descricao"><span>Observação:</span></label>
						<?php echo nl2br($objClassePg->observacao); ?>
					</div>


					<? if ($cliente->tecnico) { ?>
						<div class="field alto">
							<label><span>Técnica:</span></label>
						<?php echo $objClassePg->tecnico; ?>
						</div>
						<? } ?>

					<div class="field half">
						<label><span>Data de abertura:</span></label>
						<?php echo $objClassePg->dataabertura; ?>
					</div>

						<? if ($cliente->datafechamento) { ?>
						<div class="field half">
							<label><span>Data de fechamento:</span></label>
						<?php echo $objClassePg->datafechamento; ?>
						</div>
						<? } ?>

					<div class="field half">
						<label><span>Status:</span></label>
						<?php $status = array('Fechado', 'Aberto', 'Aguardando analise' ); 
						echo $status[$objClassePg->status];
						?>
					</div>

				</div>


				<div class="caixa">
					<h3>Dados do cliente </h3>
					<div class="field half">
						<label><span>Nome do responsável:</span></label>
						<?php echo $cliente->nome_gerente; ?>
					</div>

					<div class="field half">
						<label><span>Email:</span></label>
						<?php echo $cliente->email; ?>
					</div>

					<div class="field half">
						<label><span>Telefone:</span></label>
						<?php echo $cliente->telefone; ?>
					</div>

					<div class="field half">
						<label><span>Detalhes:</span></label>
						<a href="../cliente/detalhes.php?id=<?=$cliente->id?>">aqui</a>
					</div>
				</div>



			</div>
		</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
	</body>
</html>
