<?php 
die("Busca desativada.");

include('inc/inc_start.php'); 

$db = new DB();
$user = new UsuarioCMS($db->connect());
$user->autentica();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd>
<html>
<head>
<?php include(DIR_CMS_ROOT . 'inc/inc_header.php'); ?>
<style type="text/css">
.texto_busca em { color: #b3001e; font-style: normal; background: #FFFF66;}
</style>
</head>
<body>
<?php include(DIR_CMS_ROOT . 'inc/inc_topo.php'); ?>
<div id="central">
<?php include(DIR_CMS_ROOT . 'inc/inc_menu.php'); ?>
<div id="conteudo">


<h1><strong>Busca</strong></h1>

<?php
$vetor_classes = array('UsuarioCMS');
$retorno_busca = Utils::busca($vetor_classes, $palavra, $pg, null, false);
$vetor = $retorno_busca['itens'];

//______PAGINAÇÃO_____________
$reg_por_pg = 5;
$paginacao = new PaginacaoVetor($vetor, $reg_por_pg, $pg);
$paginacao->addVar('palavra', $palavra);
//__________________________*/

if(!$vetor) 
{
	$paginacao->displayFrase();
} 
else 
{
	$paginacao->display();
	?>
    <p><?=$paginacao->displayFrase();?><br /></p>
    <hr />
    <?
	
	$vetor_print = Utils::get_fatia_vetor($vetor, $reg_por_pg, $pg);
	
	foreach($vetor_print as $item)
	{
		?>
        <span class="texto_busca">
            <p>
                <strong><?=$item['rotulo_classe']?></strong> - <a href="<?=DIR_CMS_HTM_ROOT?><?=$item['destino_cms']?>"><?=Utils::destaca_ocorrencia($item['titulo'], array($palavra))?></a> <? if($item['quando']!='') { ?>(<?=$item['quando']?>) <? } ?>
            </p>
                <?=Utils::destaca_ocorrencia(Utils::formata_texto_busca($item['texto'], 200), array($_POST['palavra']))?>
            <p>
                <a href="<?=DIR_CMS_HTM_ROOT?><?=$item['destino_cms']?>" class="bt_ico ico_view_on" title="detalhes"><em>detalhes</em></a>
            </p>        
        </span>
        <hr />
		<?
	}
	
	$paginacao->display();
}

?>




</div>
</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
</body>
</html>
