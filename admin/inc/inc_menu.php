<?php
$pasta = Authenticate::this_folder_name();
$user = ContainerDi::getObject('UsuarioCMS');
$con_cms_user = $user->find($con_cms_user->id);
?>
<div id="menu">

	<div id="menu_user" class="ui-corner-all">
		<?php echo $con_cms_user->nome; ?><br />
		<img src="<?php echo $con_cms_user->get_imagem(null, true); ?>" class="img_usuario" align="left" />
		<a href="<?php echo DIR_CMS_HTM_ROOT;?>preferencias/perfil.php">meu perfil</a> | <a href="<?php echo DIR_CMS_HTM_ROOT;?>encerrar_sessao.php">sair</a>
		<a href="<?php echo DIR_CMS_HTM_ROOT;?>ajuda">ajuda</a>
	</div>
	
	
	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'usuarios');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_usuarios').slideToggle()">Usuários</h3>
		<ul id="mn_usuarios">
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>usuarios/listar_usuarios.php">Listar usuários</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>usuarios/inserir_usuario.php">Inserir usuário</a></li>
		</ul>
		<?php
	}
	?>
	
    
	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'rede');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_rede').slideToggle()">Rede</h3>
		<ul id="mn_rede">
			<li>&raquo; Unidades</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/listar_unidades.php">Listar unidades</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/inserir_unidade.php">Inserir unidade</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/listar_perfis_tabloide.php">Listar perfis</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/inserir_perfil_tabloide.php">Inserir perfil</a></li>
			<li>&raquo; Departamentos</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/listar_departamentos.php">Listar departamentos</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/inserir_departamento.php">Inserir departamento</a></li>
			<li>&raquo; Serviços</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/listar_servicos.php">Listar serviços</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>rede/inserir_servico.php">Inserir serviço</a></li>
		</ul>
		<?php
	}
	?>
    
	
	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'produtos');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_produtos').slideToggle()">Economize</h3>
		<ul id="mn_produtos">
			<li>&raquo; Produtos</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/listar_produtos.php">Listar produtos</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/inserir_produto.php">Inserir produto</a></li>
			<li>&raquo; Ofertas</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/listar_ofertas.php">Listar ofertas</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/inserir_oferta.php">Inserir oferta</a></li>
			<li>&raquo; Tablóides</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/listar_tabloides.php">Listar tablóides</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/inserir_tabloide.php">Inserir tablóide</a></li>
			<li>&raquo; Marcas especiais</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/listar_marcas.php">Listar marcas</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/inserir_marca.php">Inserir marca</a></li>

			<li>&raquo; Marcas proprias</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/listar_marcasproprias.php">Listar produtos</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/marcapropria.php">Inserir produto</a></li>
			<li>&raquo; Promoções</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/promocao_listar.php">Listar promoções</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>produtos/promocao.php">Inserir promoção</a></li>
			<li>&raquo; Blits saúde</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>produtos/blits_listar.php">Listar calendário de blits</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>produtos/blits.php">Inserir blits</a></li>
			<li>&raquo; Serviços Coop</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>produtos/servico_listar.php">Listar serviços Coop</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>produtos/servico_reciclagem_listar.php">Listar estações</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT; ?>produtos/servico_reciclagem.php">Inserir estação</a></li>
		</ul>
		<?php
	}
	?>
    


	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'cozinhe');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_cozinhe').slideToggle()">Cozinhe</h3>
		<ul id="mn_cozinhe">
			<li>&raquo; Chefs</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>cozinhe/listar_chefs.php">Listar chefs</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT; ?>cozinhe/inserir_chef.php">Inserir chef</a></li>
			<li>&raquo; Receitas</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>cozinhe/listar_receitas.php">Listar receitas</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>cozinhe/inserir_receita.php">Inserir receita</a></li>
			<li>&raquo; Cardápios</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>cozinhe/listar_cardapios.php">Listar cardápios</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>cozinhe/inserir_cardapio.php">Inserir cardápio</a></li>
			<li>&raquo; Dica Rápida</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>cozinhe/dicarapida_listar.php">Listar dicas</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>cozinhe/dicarapida.php">Inserir dica</a></li>
		</ul>
		<?php
	}
	?>
    
	
	
	
	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'noticias');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_noticias').slideToggle()">Conheça</h3>
		<ul id="mn_noticias">
			<li>&raquo; Notícias</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>noticias/listar_noticias.php">Listar notícias</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>noticias/inserir_noticia.php">Inserir notícia</a></li>
			<li>&raquo; Revista</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>noticias/listar_revistas.php">Listar revistas</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>noticias/inserir_revista.php">Inserir revista</a></li>
			<li>&raquo; História</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>noticias/historia_listar.php">Listar slides</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>noticias/historia.php">Inserir slide</a></li>
		</ul>
		<?php
	}
	?>





	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'facaparte');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_facaparte').slideToggle()">Faça parte</h3>
		<ul id="mn_facaparte">
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>facaparte/listar_palestras.php">Listar palestras</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT; ?>facaparte/inserir_palestra.php">Inserir palestra</a></li>
			<li>&raquo; Programação</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>facaparte/programacao.php">Inserir programação</a></li>
			<li>&raquo; Planeta Coop</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>facaparte/planeta_projeto.php">Inserir Projeto</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT; ?>facaparte/planeta_projeto_listar.php">Listar Projetos</a></li>
		</ul>
		<?php
	}
	?>
    




	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'mexase');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_mexase').slideToggle()">Mexa-se</h3>
		<ul id="mn_mexase">
			<li>&raquo; Posts</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/listar_posts.php">Listar posts</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/inserir_post.php">Inserir post</a></li>
			<li>&raquo; Comentários</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/listar_comentarios.php">Listar comentários</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/inserir_comentario.php">Inserir comentário</a></li>
			<li>&raquo; Categorias</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/listar_categorias.php">Listar categorias</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/inserir_categoria.php">Inserir categoria</a></li>
			<li>&raquo; Atividades</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/listar_atividades.php">Listar atividades</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/inserir_atividade.php">Inserir atividade</a></li>
			<li>&raquo; Conheça o programa</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/conheca_programa_listar.php">Módulos</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/ativprogramacao_listar.php">Atividades semanais</a></li>
			<?php /* <li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/conheca_programa.php">Inserir módulo</a></li> */ ?>
			<li>&raquo; Planilhas de treino</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/planilha_listar.php">Listar planilhas</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>mexase/planilha_treino.php">Inserir planilha</a></li>

		</ul>
		<?php
	}
	?>
    
	
	

	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'paginas_estaticas');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_paginas_estaticas').slideToggle()">Home</h3>
		<ul id="mn_paginas_estaticas">
			<li>&raquo; Módulos</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>paginas_estaticas/listar_modulos.php">Listar módulos</a></li>
			<li>&raquo; Mídia box</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>paginas_estaticas/listar_banners.php">Listar banners</a></li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>paginas_estaticas/inserir_banner.php">Inserir banner</a></li>
			<li>&raquo; Parceiro</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>paginas_estaticas/detalhes_logo_parceiro.php">Logotipo parceiro</a></li>
			<li>&raquo; Páginas estáticas</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>paginas_estaticas/listar_paginas.php">Listar páginas</a></li>
			<?php
			if(PaginaEstatica::PODE_DELETAR)
			{
				?>
				<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>paginas_estaticas/inserir_pagina.php">Inserir página</a></li>
				<?php
			}
			?>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>paginas_estaticas/listar_modulos.php">Módulos da HOME</a></li>
		</ul>
		<?php
	}
	?>
    
	<?php 
	$vetor_menu = ModuloCMS::getVetor($pasta, 'concursos');
	if($vetor_menu['auth'] && $vetor_menu['current'])
	{
		?>
		<h3 onclick="$('#mn_concursos').slideToggle()">Concursos</h3>
		<ul id="mn_concursos">
			<li>&raquo; A vida é movimento</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>concursos/listar_inscricoes_vida.php">Listar inscrições</a></li>
			<li>&raquo; QR Code</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>concursos/qr_code.php">Estatísticas</a></li>
			<li>&raquo; Cupons mobile</li>
			<li><a href="<?php echo DIR_CMS_HTM_ROOT;?>concursos/listar_cupons.php">Listar cupons</a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>concursos/inserir_cupom.php">Inserir cupom</a></li>
			<li>&raquo; Histórias</li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>concursos/minhahistoria_listar.php">Listar </a></li>
			<li class="last"><a href="<?php echo DIR_CMS_HTM_ROOT;?>concursos/minhahistoria_exportar.php">Exportar</a></li>
		</ul>
		<?php
	}
	?>
    



	
</div>    