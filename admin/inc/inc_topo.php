<?php
$pasta = Authenticate::this_folder_name();
?>
<div id="row_topo">
    <div id="topo">
        <h1><a href="<?php echo DIR_CMS_HTM_ROOT; ?>home.php"></a></h1>
        
		
<!--		<form name="buscamenu" id="buscamenu" action="<?php echo DIR_CMS_HTM_ROOT; ?>busca.php" onsubmit="return checar(this)" method="post">
			<div class="field">
				<?php
				$palavra_padrao = 'Buscar...';
				$palavra = isset($palavra) ? $palavra : $palavra_padrao;
				?>
				<label for="palavra"><span>Busca</span></label>
				<a href="#" class="ui-icon ui-icon-triangle-1-e ui-state-default ui-corner-all" title="OK"><em>OK</em></a>
				<input type="text" id="palavra" name="palavra" value="<?php echo $palavra; ?>" onblur="if (this.value == '') {this.value = '<?php echo $palavra; ?>';}" onfocus="if (this.value == '<?php echo $palavra; ?>') {this.value = '';}" maxlength="200" />
			</div>
			<input type="submit" class="submit" />
		</form>-->
		
		
		
        <div style="position: absolute; left: 170px; top: 101px;">
            <ul id="menusup" style="display: none;">
            
			<?php 
			$vetor_menu = ModuloCMS::getVetor($pasta, 'usuarios');
			if($vetor_menu['auth'])
			{
				?>
				<li>Usuários
					<ul>
						<li><img src="<?php echo DIR_CMS_HTM_ROOT; ?>imagens/icones/bt_mn_usuarios.png" alt="" border="0" /><a href="<?php echo DIR_CMS_HTM_ROOT; ?>usuarios/listar_usuarios.php">Listar usuários</a></li>
						<li><img src="<?php echo DIR_CMS_HTM_ROOT; ?>imagens/icones/bt_mn_novo_usuario.png" alt="" border="0" /><a href="<?php echo DIR_CMS_HTM_ROOT; ?>usuarios/inserir_usuario.php">Inserir usuário</a></li>
					</ul>
				</li>
				<?php
			}
			?>
			<li></li>
			<?php 
			$vetor_menu = ModuloCMS::getVetor($pasta, 'chamado');
			if($vetor_menu['auth'])
			{
				?>
				<li>Chamados
					<ul>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>chamado/chamado.php">Novo</a></li>
						<li>Listar
							<ul>
								<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>chamado/listar.php?filtro=todos">Todos</a></li>
								<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>chamado/listar.php?filtro=aberto">Abertos</a></li>
								<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>chamado/listar.php?filtro=aguarde">Aguardando resposta</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<?php
			}
			?>
			<li></li>
			<?php 
			$vetor_menu = ModuloCMS::getVetor($pasta, 'cliente');
			if($vetor_menu['auth'])
			{
				?>
				<li>Clientes
					<ul>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>cliente/form.php">Inserir</a></li>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>cliente/listar.php">Listar</a></li>
					</ul>
				</li>
				<?php
			}
			?>
			
			
			<li></li>
			<?php 
			$vetor_menu = ModuloCMS::getVetor($pasta, 'equipamento');
			if($vetor_menu['auth'])
			{
				?>
				<li>Equipamentos
					<ul>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>equipamento/form.php">Inserir</a></li>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>equipamento/listar.php">Listar</a></li>
					</ul>
				</li>
				<?php
			}
			?>
				
			<li></li>
			<?php 
			$vetor_menu = ModuloCMS::getVetor($pasta, 'queda');
			if($vetor_menu['auth'])
			{
				?>
				<li>Quedas
					<ul>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>queda/listar.php">Listar todas</a></li>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>queda/relatorio.php">Relatório</a></li>
					</ul>
				</li>
				<?php
			}
			?>
				
			<li></li>
			<?php 
			$vetor_menu = ModuloCMS::getVetor($pasta, 'tecnico');
			if($vetor_menu['auth'])
			{
				?>
				<li>Técnicos
					<ul>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>tecnico/form.php">Inserir</a></li>
						<li><a href="<?php echo DIR_CMS_HTM_ROOT; ?>tecnico/listar.php">Listar</a></li>
					</ul>
				</li>
				<?php
			}
			?>

            </ul>
        </div>
    
    </div>	
</div>