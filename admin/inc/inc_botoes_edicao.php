<?php

$itemLista = isset ($itemLista) ? $itemLista : $objClassePg; // a var item lista vai existir quando for uma listagem

if (isset($_GET['id'])) {
	$bt_view = '<a href="'.constant("{$classePagina}::PG_LISTAR").'" class="bt_ico ico_list" title="listar"><em>listar</em></a>';	
}else{
	$bt_view = '<a href="'.constant("{$classePagina}::PG_DETALHE").'?id=' . $itemLista->id . '" class="bt_ico ico_view" title="detalhes"><em>detalhes</em></a>';
}

$bt_edit = '<a href="'.constant("{$classePagina}::PG_EDITAR").'?id=' . $itemLista->id . '" class="bt_ico ico_edit" title="editar"><em>editar</em></a>';

$classe_del = $itemLista->pode_deletar() ? '' : 'bt_ico_off';
$bt_del = '<a href="'.DIR_CMS_HTM_ROOT.'excluir.php?id=' . $itemLista->id . '&classe='.$classePagina.'" class="' . $classe_del . ' bt_ico ico_del" title="excluir"><em>excluir</em></a>';

$classe_visibilidade = $itemLista->visible==1 ? 'ico_olho_on_on' : 'ico_olho_off_on';
$bt_olho = '<a href="#" onclick="return toggle_exibir(\''.$classePagina.'\', ' . $itemLista->id . ', this)" class="bt_ico ico_olho ' . $classe_visibilidade . '" title="visibilidade"><em>visibilidade</em></a>';

$botoes_edicao = $bt_view . $bt_edit . $bt_del . $bt_olho;

return $botoes_edicao;

?>
